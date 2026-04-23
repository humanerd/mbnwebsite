<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\AdminController;
use App\Controllers\ApplicationController;
use App\Controllers\PageController;
use App\Controllers\SystemController;

final class App
{
    public function run(): void
    {
        $router = new Router();

        $router->get('/', [PageController::class, 'home']);
        $router->get('/how-it-works', [PageController::class, 'howItWorks']);
        $router->get('/what-you-receive', [PageController::class, 'whatYouReceive']);
        $router->get('/available-businesses', [PageController::class, 'availableBusinesses']);
        $router->get('/businesses/mobile-body-sculpting-wellness', [PageController::class, 'bodySculpting']);
        $router->get('/businesses/mobile-pet-grooming', [PageController::class, 'petGrooming']);
        $router->get('/capital-financing', [PageController::class, 'capitalFinancing']);
        $router->get('/for-operators', [PageController::class, 'forOperators']);
        $router->get('/platform-systems', [PageController::class, 'platformSystems']);
        $router->get('/legal-structure', [PageController::class, 'legalStructure']);
        $router->get('/about-mbn', [PageController::class, 'about']);

        $router->get('/apply', [ApplicationController::class, 'show']);
        $router->post('/apply', [ApplicationController::class, 'store']);
        $router->get('/apply/thank-you', [ApplicationController::class, 'thankYou']);

        $router->get('/admin/login', [AdminController::class, 'loginForm']);
        $router->post('/admin/login', [AdminController::class, 'login']);
        $router->post('/admin/logout', [AdminController::class, 'logout']);
        $router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
        $router->get('/admin/applications/view', [AdminController::class, 'show']);
        $router->post('/admin/applications/status', [AdminController::class, 'updateStatus']);

        $router->get('/sitemap.xml', [SystemController::class, 'sitemap']);
        $router->get('/robots.txt', [SystemController::class, 'robots']);

        $router->dispatch(new Request());
    }
}
