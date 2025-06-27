<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title . " | " . config('app.name') ?? config('app.name') }}</title>

    @foreach(config('app.available_locales') as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ route('lang.switch', $locale) }}" />
    @endforeach

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <meta name="apple-mobile-web-app-title" content="LoFo" />
    <meta name="language" content="{{ app()->getLocale() }}">

    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-clifford: #da373d;
        }
    </style>
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-S7Z3EJJM1P"></script>
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
    </script>

    <link rel="stylesheet" href="{{ asset('libs/cookieconsent/cookieconsent.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            font-weight: 300;
        }
        button,a {
            cursor: pointer;
        }
        .particles-js {
            position: relative;
            overflow: hidden;
            background-color: #FDFDFC;
        }
        .pjs-ontop {
            position: relative;
            z-index: 1;
        }
        .particles-js-canvas-el {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 0;
        }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
        .gradient-text {
            animation: gradientShift 8s linear infinite;
            background-size: 200% auto;
            background-clip: text;
            text-fill-color: transparent;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: background-position 0.5s ease-in-out;
        }
        .kenburns-slide {
            animation: kenburns-zoom 12s ease-in-out forwards;
        }
        @keyframes squeeze {
            0%, 100% {
                transform: scaleX(1) scaleY(1);
            }
            30% {
                transform: scaleX(1.2) scaleY(0.8);
            }
            60% {
                transform: scaleX(0.9) scaleY(1.1);
            }
        }
        @keyframes gradientShift {
            from {
                -webkit-filter: hue-rotate(0deg);
            }
            to {
                -webkit-filter: hue-rotate(-360deg);
            }
        }
        @keyframes kenburns-zoom {
            0% {
                transform: scale(1.1) translate(0, 0);
            }
            100% {
                transform: scale(1.2) translate(-2%, -2%);
            }
        }

        .shimmer-animation {
            animation: shimmer 2s infinite cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
        .animate-opacity {
            animation: fadeIn 0.3s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        [wire\:loading].grid {
            animation: contentFade 0.3s ease-out;
        }
        [wire\:loading\.remove].grid {
            animation: contentFade 0.3s ease-out;
        }
        @keyframes contentFade {
            from {
                opacity: 0.5;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .item-enter-active,
        .item-leave-active {
            transition: all 0.3s ease;
        }
        .item-enter-from,
        .item-leave-to {
            opacity: 0;
            transform: translateY(10px);
        }
    </style>
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
