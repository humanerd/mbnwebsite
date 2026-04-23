<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Core\Validator;
use App\Models\Application;

final class ApplicationController extends Controller
{
    public function show(): void
    {
        $this->view('pages/apply', ['meta' => default_meta('Apply to Become an Operator', 'Submit an operator application for a standardized MBN business issuance.')]);
    }

    public function store(): void
    {
        if (!Csrf::verify((string) $this->request->input('csrf_token'))) {
            flash('error', 'Invalid security token. Please retry.');
            $this->response->redirect('/apply');
        }

        if (trim((string) $this->request->input('website')) !== '') {
            flash('error', 'Spam detected.');
            $this->response->redirect('/apply');
        }

        if (RateLimiter::tooManyAttempts('apply:' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 5, 600)) {
            flash('error', 'Too many submissions. Please wait before retrying.');
            $this->response->redirect('/apply');
        }

        $data = [
            'full_name' => trim((string) $this->request->input('full_name')),
            'email' => trim((string) $this->request->input('email')),
            'phone' => trim((string) $this->request->input('phone')),
            'city_state' => trim((string) $this->request->input('city_state')),
            'desired_business_type' => trim((string) $this->request->input('desired_business_type')),
            'available_capital' => trim((string) $this->request->input('available_capital')),
            'financing_needed' => trim((string) $this->request->input('financing_needed')),
            'relevant_experience' => trim((string) $this->request->input('relevant_experience')),
            'timeline_to_launch' => trim((string) $this->request->input('timeline_to_launch')),
            'business_reason' => trim((string) $this->request->input('business_reason')),
            'agreement_acknowledged' => $this->request->input('agreement_acknowledged') ? 1 : 0,
            'status' => 'New',
            'ip_address' => substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45),
            'user_agent' => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        ];

        with_old($data);
        $errors = $this->validate($data);

        if ($errors !== []) {
            flash('error', implode(' ', $errors));
            $this->response->redirect('/apply');
        }

        (new Application())->create($data);
        clear_old();
        RateLimiter::clear('apply:' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));

        $this->notify($data);

        $this->response->redirect('/apply/thank-you');
    }

    public function thankYou(): void
    {
        $this->view('pages/thank-you', ['meta' => default_meta('Submission Received', 'Your MBN operator application has been received and is under review.')]);
    }

    private function validate(array $data): array
    {
        $errors = [];
        foreach (['full_name', 'email', 'phone', 'city_state', 'desired_business_type', 'available_capital', 'financing_needed', 'relevant_experience', 'timeline_to_launch', 'business_reason'] as $field) {
            if (!Validator::required($data[$field])) {
                $errors[] = 'All required fields must be completed.';
                break;
            }
        }

        if (!Validator::email($data['email'])) {
            $errors[] = 'Enter a valid email address.';
        }

        if (!in_array($data['financing_needed'], ['Yes', 'No'], true)) {
            $errors[] = 'Invalid financing selection.';
        }

        if ($data['agreement_acknowledged'] !== 1) {
            $errors[] = 'You must acknowledge the standardized issuance model.';
        }

        foreach (['full_name', 'email', 'phone', 'city_state', 'desired_business_type', 'available_capital', 'timeline_to_launch'] as $short) {
            if (!Validator::max($data[$short], 190)) {
                $errors[] = 'One or more fields exceeded maximum length.';
                break;
            }
        }

        foreach (['relevant_experience', 'business_reason'] as $long) {
            if (!Validator::max($data[$long], 2000)) {
                $errors[] = 'Please keep long responses concise (max 2000 chars).';
            }
        }

        return array_values(array_unique($errors));
    }

    private function notify(array $data): void
    {
        if (!config('app.mail_enabled', false)) {
            return;
        }

        $to = config('app.admin_email');
        $subject = 'New MBN operator application';
        $body = "New operator application\n\n";
        foreach ($data as $key => $value) {
            $body .= ucfirst(str_replace('_', ' ', $key)) . ': ' . $value . "\n";
        }

        $headers = 'From: ' . config('app.mail_from') . "\r\n" . 'Content-Type: text/plain; charset=UTF-8';
        @mail((string) $to, $subject, $body, $headers);
    }
}
