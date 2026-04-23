<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Models\AdminUser;
use App\Models\Application;

final class AdminController extends Controller
{
    public function loginForm(): void
    {
        if (Auth::check()) {
            $this->response->redirect('/admin/dashboard');
        }

        $this->view('admin/login', ['meta' => default_meta('Admin Login')]);
    }

    public function login(): void
    {
        if (!Csrf::verify((string) $this->request->input('csrf_token'))) {
            flash('error', 'Invalid token.');
            $this->response->redirect('/admin/login');
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $limitKey = 'admin-login:' . $ip;
        if (RateLimiter::tooManyAttempts($limitKey, 5, 900)) {
            flash('error', 'Too many failed attempts. Retry later.');
            $this->response->redirect('/admin/login');
        }

        $email = trim((string) $this->request->input('email'));
        $password = (string) $this->request->input('password');

        $user = (new AdminUser())->findByEmail($email);
        if ($user === null || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Invalid credentials.');
            $this->response->redirect('/admin/login');
        }

        Auth::login((int) $user['id']);
        RateLimiter::clear($limitKey);
        $this->response->redirect('/admin/dashboard');
    }

    public function logout(): void
    {
        if (Csrf::verify((string) $this->request->input('csrf_token'))) {
            Auth::logout();
        }

        $this->response->redirect('/admin/login');
    }

    public function dashboard(): void
    {
        $this->guard();

        $status = trim((string) $this->request->input('status', ''));
        $business = trim((string) $this->request->input('business', ''));
        $query = trim((string) $this->request->input('q', ''));

        $applications = (new Application())->paginate($status, $business, $query);
        $this->view('admin/dashboard', [
            'meta' => default_meta('Admin Dashboard'),
            'applications' => $applications,
            'filters' => compact('status', 'business', 'query'),
        ]);
    }

    public function show(): void
    {
        $this->guard();
        $id = (int) $this->request->input('id', 0);
        $application = (new Application())->find($id);

        if ($application === null) {
            http_response_code(404);
            echo 'Not found';
            return;
        }

        $this->view('admin/view', ['meta' => default_meta('Application Detail'), 'application' => $application]);
    }

    public function updateStatus(): void
    {
        $this->guard();

        if (!Csrf::verify((string) $this->request->input('csrf_token'))) {
            flash('error', 'Invalid token.');
            $this->response->redirect('/admin/dashboard');
        }

        $id = (int) $this->request->input('id', 0);
        $status = trim((string) $this->request->input('status'));
        $allowed = ['New', 'Reviewing', 'Qualified', 'Not Qualified', 'Contacted'];

        if ($id < 1 || !in_array($status, $allowed, true)) {
            flash('error', 'Invalid status request.');
            $this->response->redirect('/admin/dashboard');
        }

        (new Application())->updateStatus($id, $status);
        flash('success', 'Status updated.');
        $this->response->redirect('/admin/applications/view?id=' . $id);
    }

    private function guard(): void
    {
        if (!Auth::check()) {
            $this->response->redirect('/admin/login');
        }
    }
}
