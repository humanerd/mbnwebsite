<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class SystemController extends Controller
{
    public function sitemap(): void
    {
        $paths = [
            '/', '/how-it-works', '/what-you-receive', '/available-businesses',
            '/businesses/mobile-body-sculpting-wellness', '/businesses/mobile-pet-grooming', '/capital-financing', '/for-operators',
            '/platform-systems', '/legal-structure', '/about-mbn', '/apply',
        ];

        header('Content-Type: application/xml; charset=utf-8');
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($paths as $path) {
            echo '<url><loc>' . e(url($path)) . '</loc><changefreq>weekly</changefreq></url>';
        }
        echo '</urlset>';
    }

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo "User-agent: *\n";
        echo "Allow: /\n\n";
        echo 'Sitemap: ' . url('/sitemap.xml');
    }
}
