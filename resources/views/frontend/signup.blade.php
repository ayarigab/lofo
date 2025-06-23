@include('partials.frontend.header', ['title' => __('Sign Up')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <div class="mx-auto max-w-7xl antialiased">
        @include('partials.frontend.navbar')
    </div>
    <section class="relative bg-gray-50 p-20">
        <img src="{{ asset('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
        <div class="max-w-3xl px-20 mx-auto relative z-20">
            <div>
                <h1 class="mb-6 text-3xl font-bold text-sky-900 sm:text-4xl">Create a new account</h1>
                <p class="mb-8 text-lg text-gray-600">Join the community to showcase more lost items or claim yours for free. Please
                    fill in your details to register below.</p>

                <div class="space-y-6">
                </div>
            </div>
            @livewire('claim-register')
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
