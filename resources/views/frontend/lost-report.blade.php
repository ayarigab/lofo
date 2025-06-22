@include('partials.frontend.header', ['title' => __('Post Lost Item')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <div class="mx-auto max-w-7xl antialiased">
        @include('partials.frontend.navbar')
    </div>
    <section class="relative bg-gray-50 p-20">
        <img src="{{ asset('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
        <div class="max-w-3xl px-20 mx-auto relative z-20">
            <div>
                <h2 class="mb-6 text-3xl font-bold text-sky-900 sm:text-4xl">Post an item you've found</h2>
                <p class="mb-8 text-lg text-gray-600">Lets join hands together in helping the community solve our most common problem. Post your item to help get it back to it's rightful owner.</p>

                <div class="space-y-6">
                    <!-- Your contact info blocks remain the same -->
                </div>
            </div>
            @livewire('post-lost-form')
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
