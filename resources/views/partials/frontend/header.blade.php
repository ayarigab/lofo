<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr' }}">

<head>
    <!-- Basic Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>"{{ ($title ?? '') . (isset($title) ? ' | ' . config('app.name') : config('app.name')) }}"</title>

    <!-- Language & Localization -->
    <meta name="language" content="{{ app()->getLocale() }}">
    @foreach(config('app.available_locales') as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ route('lang.switch', $locale) }}">
    @endforeach

    <!-- Favicons & App Icons -->
    <link rel="shortcut icon" href="{{ assetV('icons/favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ assetV('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-24x24.png') }}" sizes="24x24">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-48x48.png') }}" sizes="48x48">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-64x64.png') }}" sizes="64x64">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-128x128.png') }}" sizes="128x128">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-256x256.png') }}" sizes="256x256">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-512x512.png') }}" sizes="512x512">
    <link rel="icon" type="image/png" href="{{ assetV('icons/favicon-1024x1024.png') }}" sizes="1024x1024">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ assetV('icons/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ assetV('icons/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ assetV('icons/apple-touch-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ assetV('icons/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ assetV('icons/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ assetV('icons/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ assetV('icons/apple-touch-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ assetV('icons/apple-touch-icon-180x180.png') }}">
    <link rel="apple-touch-icon" href="{{ assetV('icons/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ assetV('icons/apple-touch-icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="256x256" href="{{ assetV('icons/apple-touch-icon-256x256.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ assetV('icons/apple-touch-icon-512x512.png') }}">


    <!-- PWA Capabilities -->
    <link rel="manifest" href="{{ assetV('icons/site.webmanifest') }}">
    <meta name="theme-color" content="{{ config('naaba.app_main_color') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-TileImage" content="{{ assetV('favicon.svg') }}">
    <meta name="msapplication-TileColor" content="{{ config('naaba.app_main_color') }}">

    <!-- SEO Essentials -->
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $description ?? 'Lost & Found - Your trusted platform for lost items.' }}">
    <meta name="url" content="{{ url()->current() }}">
    <meta name="keywords" content="{{ $keywords ?? 'lost and found, lost items, claim lost items, report lost items' }}">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index,follow">

    <!-- Ownership -->
    <meta name="author" content="{{ config('naaba.author') }}">
    <meta name="copyright" content="Copyright © {{ date('Y') }} {{ config('app.name') }}">

    <!-- Geographical Meta Tags -->
    <meta name="geo.region" content="{{ config('naaba.geo_region', 'US') }}">
    <meta name="geo.placename" content="{{ config('naaba.geo_city', 'Columbus') }}">
    <meta name="distribution" content="Global">
    <meta name="audience" content="all">
    <meta name="relevance" content="high">
    <meta name="rating" content="general">

    <!-- Open Graph (Facebook/LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ ($title ?? '') . (isset($title) ? " | " . config('app.name') : config('app.name')) }}">
    <meta property="og:description" content="{{ $description ?? 'Lost & Found - Your trusted platform for lost items.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ assetV('images/social-share.png') }}">
    <meta property="og:image:small" content="{{ assetV('images/social-share-small.webp') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $title . ' | ' . (config('app.name') ?? '') }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:updated_time" content="{{ now()->toIso8601String() }}">
    <meta property="og:author" content="{{ config('naaba.author') }}">
    <meta property="og:author:url" content="{{ config('naaba.author_url') }}">
    <meta property="og:author:email" content="{{ config('naaba.author_email') }}">
    <meta property="og:author:phone" content="{{ config('naaba.author_phone') }}">
    <meta property="og:author:address" content="{{ config('naaba.author_address') }}">
    <meta property="og:author:social" content="{{ json_encode(config('naaba.author_social')) }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ config('app.name') }}">
    <meta name="twitter:creator" content="{{ config('naaba.author') }}">
    <meta name="twitter:title" content="{{ ($title ?? '') . (isset($title) ? " | " . config('app.name') : config('app.name')) }}">
    <meta name="twitter:description" content="{{ $description ?? 'Lost & Found - Your trusted platform for lost items.' }}">
    <meta name="twitter:image" content="{{ assetV('images/social-share.png') }}">
    <meta name="twitter:image:alt" content="{{ $title . ' | ' . (config('app.name') ?? '') }}">
    <meta name="twitter:site:id" content="{{ config('naaba.author_social.twitter') }}">
    <meta name="twitter:creator:id" content="{{ config('naaba.author_social.twitter') }}">
    <meta name="twitter:app:name:iphone" content="{{ config('app.name') }}">
    <meta name="twitter:app:name:ipad" content="{{ config('app.name') }}">
    <meta name="twitter:app:name:googleplay" content="{{ config('app.name') }}">
    <meta name="twitter:app:id:iphone" content="{{ config('naaba.app_store_id') }}">
    <meta name="twitter:app:id:ipad" content="{{ config('naaba.app_store_id') }}">
    <meta name="twitter:app:id:googleplay" content="{{ config('naaba.play_store_id') }}">
    <meta name="twitter:app:url:iphone" content="{{ config('naaba.app_store_url') }}">
    <meta name="twitter:app:url:ipad" content="{{ config('naaba.app_store_url') }}">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "{{ config('app.name') }}",
            "description": "{{ $description ?? 'Lost & Found - Your trusted platform for lost items.' }}",
            "url": "{{ url()->current() }}",
            "image": {
                "@type": "ImageObject",
                "url": "{{ assetV('favicon.svg') }}",
                "width": 1200,
                "height": 630
            },
            "inLanguage": "{{ app()->getLocale() }}",
            "datePublished": "{{ now()->toIso8601String() }}",
            "dateModified": "{{ now()->toIso8601String() }}",
            "author": {
                "@type": "Person",
                "name": "{{ config('naaba.author') }}",
                "url": "{{ config('naaba.author_url') }}",
                "email": "{{ config('naaba.author_email') }}",
                "telephone": "{{ config('naaba.author_phone') }}",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "{{ config('naaba.author_address') }}",
                    "addressLocality": "{{ config('naaba.geo_city', 'Columbus') }}",
                    "addressRegion": "{{ config('naaba.geo_region', 'OH') }}",
                    "postalCode": "{{ config('naaba.geo_postal_code', '43229') }}",
                    "addressCountry": "{{ config('naaba.geo_country', 'United States') }}"
                },
                "sameAs": [
                    "{{ config('naaba.author_social.twitter') }}",
                    "{{ config('naaba.author_social.facebook') }}",
                    "{{ config('naaba.author_social.instagram') }}",
                    "{{ config('naaba.author_social.linkedin') }}"
                ]
            },
            "potentialAction": {
                "@type": "SearchAction",
                "target": "?search={search_term}",
                "query-input": "required name=search_term"
            }
        }
    </script>

    <!-- Feeds & Canonical -->
    <link rel="alternate" type="application/rss+xml" title="{{ config('app.name') }} RSS Feed" href="/rss/">
    <link rel="alternate" type="application/atom+xml" title="{{ config('app.name') }} Atom Feed" href="/atom/">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Stack for Dynamic Meta Tags -->
    @stack('meta')

    <!-- DNS Prefetch for external domains -->
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.clarity.ms">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/suneditor@2.47.6/dist/css/suneditor.min.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/suneditor@2.47.6/dist/suneditor.min.js"></script>
    <script type="module">
        document.addEventListener("alpine:init", () => {
            Alpine.data('phoneInput', () => ({
                locale: "{{ app()->getLocale() }}",
                init() {
                    const input = this.$refs.phoneInput;

                    window.intlTelInput(input, {
                        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
                        i18n: this.locale,
                        geoIpLookup: (callback) => {
                            fetch("https://ipapi.co/json")
                                .then(res => res.json())
                                .then(data => callback(data.country_code || 'us'))
                                .catch(() => callback("us"));
                        },
                        strictMode: true,
                        initialCountry: this.locale.toLowerCase(),
                    });
                }
            }));
        });
    </script>
    @fluxAppearance
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-S7Z3EJJM1P"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-S7Z3EJJM1P');
    </script>
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "s3kyxozzww");
    </script>
    <script>
        var _paq = window._paq = window._paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
          var u="//analytics.decapitalgrille.com/";
          _paq.push(['setTrackerUrl', u+'matomo.php']);
          _paq.push(['setSiteId', '6']);
          var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
          g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
    </script> --}}

    <link rel="stylesheet" href="{{ assetV('libs/cookieconsent/cookieconsent.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ assetV('css/lofo.css') }}">
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kenBurnsSlider', () => ({
                currentSlide: 0,
                slides: [
                    'https://wallpapers.com/images/high/vibrant-pine-branches-jpg-4ixpboo24b48qlra.webp',
                    'https://wallpapers.com/images/high/adidas-brand-logo-on-smoke-bic7qfie10mhjg4h.webp',
                    'https://wallpapers.com/images/hd/technology-drone-on-armchair-ra6wt9otz2n56g1g.jpg'
                ],
                interval: null,
                init() {
                    this.startSlider();
                    this.$el.addEventListener('mouseenter', () => {
                        clearInterval(this.interval);
                    });
                    this.$el.addEventListener('mouseleave', () => {
                        this.startSlider();
                    });
                },
                startSlider() {
                    this.interval = setInterval(() => {
                        this.nextSlide();
                    }, 8000);
                },
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                }
            }));
        });
    </script>
</head>
