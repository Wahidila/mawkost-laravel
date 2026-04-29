<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\City;
use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $sitemap .= $this->addUrl(route('home'), '1.0', 'daily');

        // Static pages
        $sitemap .= $this->addUrl(route('tentang'), '0.8', 'monthly');
        $sitemap .= $this->addUrl(route('contact.index'), '0.8', 'monthly');
        $sitemap .= $this->addUrl(route('chat.index'), '0.7', 'weekly');
        $sitemap .= $this->addUrl(route('privacy'), '0.5', 'yearly');
        $sitemap .= $this->addUrl(route('tos'), '0.5', 'yearly');
        $sitemap .= $this->addUrl(route('refund'), '0.5', 'yearly');

        // Search page
        $sitemap .= $this->addUrl(route('kost.search'), '0.9', 'daily');

        // Cities
        $cities = City::all();
        foreach ($cities as $city) {
            $sitemap .= $this->addUrl(route('kost.byCity', $city->slug), '0.9', 'daily');
        }

        // Kosts
        $kosts = Kost::where('is_active', true)->get();
        foreach ($kosts as $kost) {
            $sitemap .= $this->addUrl(
                route('kost.show', ['citySlug' => $kost->city->slug, 'slug' => $kost->slug]),
                '0.8',
                'weekly',
                $kost->updated_at
            );
        }

        // Blog
        $sitemap .= $this->addUrl(route('blog.index'), '0.7', 'weekly');
        
        $articles = Article::where('is_published', true)->get();
        foreach ($articles as $article) {
            $sitemap .= $this->addUrl(
                route('blog.show', $article->slug),
                '0.6',
                'monthly',
                $article->updated_at
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addUrl($loc, $priority = '0.5', $changefreq = 'monthly', $lastmod = null)
    {
        $url = '  <url>' . "\n";
        $url .= '    <loc>' . htmlspecialchars($loc) . '</loc>' . "\n";
        
        if ($lastmod) {
            $url .= '    <lastmod>' . $lastmod->format('Y-m-d') . '</lastmod>' . "\n";
        }
        
        $url .= '    <changefreq>' . $changefreq . '</changefreq>' . "\n";
        $url .= '    <priority>' . $priority . '</priority>' . "\n";
        $url .= '  </url>' . "\n";
        
        return $url;
    }
}
