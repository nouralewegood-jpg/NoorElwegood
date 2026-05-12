<?php

namespace App\Services;

class SchemaService
{
    /**
     * Generate Organization schema
     *
     * @return array
     */
    public static function getOrganizationSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'بيكود',
            'url' => url('/'),
            'logo' => asset('assets-home/img/logo.png'),
            'description' => 'شركة نور الوجود هي شركة رائدة متخصصة في تطوير البرمجيات والتسويق الرقمي وخدمات الذكاء الاصطناعي والدعاية والإعلان وإدارة وسائل التواصل الاجتماعي وتصميم الجرافيك والهويات التجارية في مصر والخليج العربي بخبرة 15 عاماً',
            'foundingDate' => '2010',
            'founders' => [
                [
                    '@type' => 'Person',
                    'name' => 'بيكود'
                ]
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'مصر',
                'addressRegion' => 'القاهرة',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+20-xxxxxxxxxx',
                'contactType' => 'customer service',
                'areaServed' => ['EG', 'SA', 'AE', 'KW', 'QA', 'BH', 'OM'],
                'availableLanguage' => ['Arabic', 'English'],
            ],
            'sameAs' => [
                'https://www.facebook.com/pickod',
                'https://www.twitter.com/pickod',
                'https://www.linkedin.com/company/pickod',
                'https://www.instagram.com/pickod'
            ]
        ];
    }

    /**
     * Generate Service schema
     *
     * @param array $service
     * @return array
     */
    public static function getServiceSchema($service)
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['name'],
            'description' => $service['description'],
            'provider' => [
                '@type' => 'Organization',
                'name' => 'بيكود',
                'url' => url('/'),
            ],
            'areaServed' => [
                [
                    '@type' => 'Country',
                    'name' => 'مصر'
                ],
                [
                    '@type' => 'Country',
                    'name' => 'المملكة العربية السعودية'
                ],
                [
                    '@type' => 'Country',
                    'name' => 'الإمارات العربية المتحدة'
                ],
                [
                    '@type' => 'Country',
                    'name' => 'الكويت'
                ],
                [
                    '@type' => 'Country',
                    'name' => 'قطر'
                ],
                [
                    '@type' => 'Country',
                    'name' => 'البحرين'
                ],
                [
                    '@type' => 'Country',
                    'name' => 'عمان'
                ]
            ],
            'serviceType' => $service['type']
        ];
    }

    /**
     * Generate LocalBusiness schema
     *
     * @return array
     */
    public static function getLocalBusinessSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => 'بيكود',
            'image' => asset('assets-home/img/logo.png'),
            'url' => url('/'),
            'telephone' => '+20-xxxxxxxxxx',
            'priceRange' => '$$',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'مصر',
                'addressRegion' => 'القاهرة',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '30.0444',
                'longitude' => '31.2357'
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                    'opens' => '09:00',
                    'closes' => '17:00'
                ]
            ],
            'areaServed' => ['مصر', 'السعودية', 'الإمارات', 'الكويت', 'قطر', 'البحرين', 'عمان']
        ];
    }

    /**
     * Generate Article schema for blog posts
     *
     * @param array $post
     * @return array
     */
    public static function getArticleSchema($post)
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post['title'],
            'description' => $post['meta_description'] ?? substr(strip_tags($post['content']), 0, 160),
            'image' => $post['featured_image'] ? asset('storage/' . $post['featured_image']) : asset('assets-home/img/logo.png'),
            'datePublished' => $post['created_at'],
            'dateModified' => $post['updated_at'],
            'author' => [
                '@type' => 'Person',
                'name' => $post['author']['name'] ?? 'بيكود'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'بيكود',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets-home/img/logo.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current()
            ]
        ];
    }
}
