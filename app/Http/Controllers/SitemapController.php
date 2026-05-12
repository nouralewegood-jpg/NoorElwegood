<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     *
     * @return Response
     */
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
                      xmlns:xhtml="http://www.w3.org/1999/xhtml"
                      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
                      http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        // Add homepage
        $sitemap .= $this->addUrl(url('/'), '1.0', 'daily', now()->toIso8601String());

        // Add pages
        $pages = Page::where('is_published', 1)->get();
        foreach ($pages as $page) {
            $sitemap .= $this->addUrl(
                url('/page/' . $page->slug),
                '0.9',
                'weekly',
                $page->updated_at->toIso8601String()
            );
        }

        // Add blog posts
        $blogPosts = BlogPost::where('is_published', 1)->get();
        foreach ($blogPosts as $post) {
            $sitemap .= $this->addUrl(
                route('blog.show', $post->slug),
                '0.8',
                'weekly',
                $post->updated_at->toIso8601String()
            );
        }

        // Add services
        $services = Service::all();
        foreach ($services as $service) {
            $sitemap .= $this->addUrl(
                route('services.show', $service->slug),
                '0.9',
                'weekly',
                $service->updated_at->toIso8601String()
            );
        }

        // Add main static pages
        $staticPages = [
            'about' => '0.8',
            'services' => '0.9',
            'contact' => '0.8',
            'blog' => '0.9',
        ];

        foreach ($staticPages as $page => $priority) {
            $sitemap .= $this->addUrl(
                url('/' . $page),
                $priority,
                'weekly',
                now()->toIso8601String()
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    /**
     * Add URL to sitemap
     *
     * @param string $url
     * @param string $priority
     * @param string $changeFreq
     * @param string $lastMod
     * @return string
     */
    private function addUrl($url, $priority, $changeFreq, $lastMod)
    {
        return "\t<url>\n" .
            "\t\t<loc>" . $url . "</loc>\n" .
            "\t\t<lastmod>" . $lastMod . "</lastmod>\n" .
            "\t\t<changefreq>" . $changeFreq . "</changefreq>\n" .
            "\t\t<priority>" . $priority . "</priority>\n" .
            "\t</url>\n";
    }
}
