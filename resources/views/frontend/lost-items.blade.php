@include('partials.frontend.header', ['title' => __('Lost Items')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @livewire('lost-items')

@include('partials.frontend.footer')
</body>

</html>
