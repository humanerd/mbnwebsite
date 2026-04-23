<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class PageController extends Controller
{
    private function renderPage(string $slug, string $title, string $description): void
    {
        $this->view('pages/' . $slug, [
            'meta' => default_meta($title, $description),
            'schemaOrg' => [config('seo.organization'), config('seo.website')],
        ]);
    }

    public function home(): void { $this->renderPage('home', 'Mobile Business Issuance Platform', 'MBN issues complete, launch-ready mobile businesses with fixed scope and disciplined operator qualification.'); }
    public function howItWorks(): void { $this->renderPage('how-it-works', 'How MBN Issuance Works', 'Learn MBN’s fixed-scope issuance lifecycle from operator application through launch delivery.'); }
    public function whatYouReceive(): void { $this->renderPage('what-you-receive', 'What You Receive', 'See the complete integrated operating unit issued by MBN: physical assets, digital stack, and operating system.'); }
    public function availableBusinesses(): void { $this->renderPage('available-businesses', 'Available Mobile Business Platforms', 'Review MBN’s standardized mobile business SKUs and what categories are not offered.'); }
    public function bodySculpting(): void { $this->renderPage('body-sculpting', 'Mobile Body Sculpting & Wellness Issuance', 'A compliant, revenue-ready mobile body sculpting business issued as a standardized operating platform.'); }
    public function petGrooming(): void { $this->renderPage('pet-grooming', 'Mobile Pet Grooming Issuance', 'A practical, launch-ready mobile pet grooming business issued with equipment, systems, and SOPs.'); }
    public function capitalFinancing(): void { $this->renderPage('capital-financing', 'Capital & Financing Paths', 'Understand the three MBN entry paths and the capital expectations for qualified operators.'); }
    public function forOperators(): void { $this->renderPage('for-operators', 'For Operators', 'Who MBN is built for, who it is not for, and the execution expectations of approved operators.'); }
    public function platformSystems(): void { $this->renderPage('platform-systems', 'Platform & Systems', 'The MBN value is the operating system: templates, SOPs, digital stack, and repeatable execution.'); }
    public function legalStructure(): void { $this->renderPage('legal-structure', 'Legal & Structure', 'Understand MBN licensing model, non-franchise structure, liability boundaries, and earnings disclaimers.'); }
    public function about(): void { $this->renderPage('about', 'About Mobile Business Network', 'Why MBN exists and the operating problem it solves through standardized business issuance.'); }
}
