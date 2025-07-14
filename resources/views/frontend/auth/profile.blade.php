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
@endpush

@include('partials.frontend.header', ['title' => __('lang_v1.profile')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen font-sans">
    @auth('claimer')
    @include('partials.frontend.auth.navbar')
    <style>
        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>

    @livewire('claimer.profile-edit')

    @else
    <section class="relative bg-gray-50 p-20 text-center">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">Lost & Found Portal</h1>
            <p class="text-xl text-gray-600 mb-8">Please login to access your dashboard and manage your lost items</p>
            <a href="{{ route('claimer-login') }}"
                class="bg-[#4F46E5] hover:bg-[#4338CA] text-white px-8 py-3 rounded-lg font-medium text-lg transition duration-200 inline-block">
                Login to Your Account
            </a>
        </div>
    </section>
    @endauth

    @include('partials.frontend.auth.footer')
</body>

</html>
