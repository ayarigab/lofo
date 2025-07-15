@push('styles')
<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/de.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fa.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/hi.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/it.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/zh.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>
@endpush

@include('partials.frontend.header', ['title' => __('lang_v1.sign_up')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @include('partials.frontend.navbar')
    <style>
        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>
    <section class="relative bg-gray-50 p-20">
        <img src="{{ assetV('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
        <div class="max-w-3xl px-20 mx-auto relative z-20">
            <div>
                <h1 class="mb-6 text-3xl font-bold text-sky-900 sm:text-4xl">{{ __('lang_v1.create_a_new_account') }}</h1>
                <p class="mb-8 text-lg text-gray-600">{{ __('lang_v1.join_the_community') }}</p>

                <div class="space-y-6">
                </div>
            </div>
            @livewire('claim-register')
        </div>
    </section>
    @include('partials.frontend.footer')
</body>

</html>
