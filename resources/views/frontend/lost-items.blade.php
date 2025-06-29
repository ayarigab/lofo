@include('partials.frontend.header', ['title' => __('lang_v1.lost_items')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @livewire('lost-items')

@include('partials.frontend.footer')
</body>

</html>
