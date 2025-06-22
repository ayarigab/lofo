@include('partials.frontend.header', ['title' => __('Lost Items')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @livewire('lost-items')

@include('partials.frontend.footer')

<style>
    .shimmer-animation {
        animation: shimmer 2s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes shimmer {
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
</style>
</body>

</html>
