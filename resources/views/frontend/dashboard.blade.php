@include('partials.frontend.header', ['title' => __('Dashboard')])
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">

@auth('claimer')
    <div class="mx-auto max-w-7xl antialiased">
        @include('partials.frontend.auth.navbar')
    </div>
    <section class="relative bg-gray-50 p-20">
        <img src="{{ asset('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
    </section>
@else
    <section class="relative bg-gray-50 p-20">
        <p>You need to <a href="{{ route('claimer-login') }}" class="text-blue-600">login</a> to access this page.</p>
    </section>
@endauth

    @include('partials.frontend.auth.footer')
</body>

</html>
