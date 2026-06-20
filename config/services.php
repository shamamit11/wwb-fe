<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'wideweb_blog' => [
        'base_url' => env('WIDEWEB_BLOG_API_BASE_URL'),
        'token' => env('WIDEWEB_BLOG_API_TOKEN'),
        'timeout' => (float) env('WIDEWEB_BLOG_API_TIMEOUT', 10),
        'connect_timeout' => (float) env('WIDEWEB_BLOG_API_CONNECT_TIMEOUT', 3),
        'retry_times' => (int) env('WIDEWEB_BLOG_API_RETRY_TIMES', 2),
        'retry_sleep_ms' => (int) env('WIDEWEB_BLOG_API_RETRY_SLEEP_MS', 150),
        'cache_ttl' => (int) env('WIDEWEB_BLOG_API_CACHE_TTL', 900),
        'homepage_path' => env('WIDEWEB_BLOG_API_HOMEPAGE_PATH', 'homepage'),
        'about_path' => env('WIDEWEB_BLOG_API_ABOUT_PATH', 'public/about'),
        'categories_path' => env('WIDEWEB_BLOG_API_CATEGORIES_PATH', 'public/categories'),
        'posts_path' => env('WIDEWEB_BLOG_API_POSTS_PATH', 'public/posts'),
        'rss_path' => env('WIDEWEB_BLOG_API_RSS_PATH', 'public/rss'),
    ],

];
