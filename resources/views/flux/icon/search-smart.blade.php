{{-- Credit: Lucide (https://lucide.dev) --}}

@props([
    'variant' => 'outline',
])

@php

$classes = Flux::classes('shrink-0 w-5 h-5 transition-all duration-300 group-hover:scale-110')
    ->add(match($variant) {
        'outline' => '[:where(&)]:size-6',
        'solid' => '[:where(&)]:size-6',
        'mini' => '[:where(&)]:size-5',
        'micro' => '[:where(&)]:size-4',
    });

$strokeWidth = match ($variant) {
    'outline' => 2,
    'mini' => 2.25,
    'micro' => 2.5,
};
@endphp

<svg
    {{ $attributes->class($classes) }}
    xmlns="http://www.w3.org/2000/svg"
    data-flux-icon
    aria-hidden="true"
    viewBox="0 0 24 24">

    <path fill="currentColor"
        d="M15.088 6.412a2.84 2.84 0 0 0-1.347-.955l-1.378-.448a.544.544 0 0 1 0-1.025l1.378-.448A2.84 2.84 0 0 0 15.5 1.774l.011-.034l.448-1.377a.544.544 0 0 1 1.027 0l.447 1.377a2.84 2.84 0 0 0 1.799 1.796l1.377.448l.028.007a.544.544 0 0 1 0 1.025l-1.378.448a2.84 2.84 0 0 0-1.798 1.796l-.448 1.377l-.013.034a.544.544 0 0 1-1.013-.034l-.448-1.377a2.8 2.8 0 0 0-.45-.848"
        x-show="!sparkle" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" />

    <path fill="currentColor"
        d="M22.783 10.213l-.766-.248a1.58 1.58 0 0 1-.998-.999l-.25-.764a.302.302 0 0 0-.57 0l-.248.764a1.58 1.58 0 0 1-.984.999l-.765.248a.302.302 0 0 0 0 .57l.765.249a1.58 1.58 0 0 1 1 1.002l.248.764a.302.302 0 0 0 .57 0l.249-.764a1.58 1.58 0 0 1 .999-.999l.765-.248a.302.302 0 0 0 0-.57z"
        x-show="!sparkle" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" />

    <path fill="currentColor"
        d="M15.088 6.412a2.84 2.84 0 0 0-1.347-.955l-1.378-.448a.544.544 0 0 1 0-1.025l1.378-.448A2.84 2.84 0 0 0 15.5 1.774l.011-.034l.448-1.377a.544.544 0 0 1 1.027 0l.447 1.377a2.84 2.84 0 0 0 1.799 1.796l1.377.448l.028.007a.544.544 0 0 1 0 1.025l-1.378.448a2.84 2.84 0 0 0-1.798 1.796l-.448 1.377l-.013.034a.544.544 0 0 1-1.013-.034l-.448-1.377a2.8 2.8 0 0 0-.45-.848"
        x-show="sparkle" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 scale-50"
        x-transition:enter-end="opacity-100 scale-110" class="text-yellow-600" style="transform-origin: center" />

    <path fill="currentColor"
        d="M22.783 10.213l-.766-.248a1.58 1.58 0 0 1-.998-.999l-.25-.764a.302.302 0 0 0-.57 0l-.248.764a1.58 1.58 0 0 1-.984.999l-.765.248a.302.302 0 0 0 0 .57l.765.249a1.58 1.58 0 0 1 1 1.002l.248.764a.302.302 0 0 0 .57 0l.249-.764a1.58 1.58 0 0 1 .999-.999l.765-.248a.302.302 0 0 0 0-.57z"
        x-show="sparkle" x-transition:enter="transition-all duration-300 delay-100"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-110"
        class="text-yellow-400" style="transform-origin: center" />

    <path fill="currentColor"
        d="M11.663 3.2a7 7 0 1 0 2.528 12.407l5.102 5.101a1 1 0 0 0 1.414-1.414l-5.1-5.1A6.97 6.97 0 0 0 17 10v-.048a1.5 1.5 0 0 1-.54.097c-.659-.002-1.347-.427-1.56-1.05v-.003q.099.488.1 1.004a5 5 0 1 1-3.852-4.868A1.6 1.6 0 0 1 11 4.47c.001-.517.257-.983.664-1.27"
        :class="{
            'motion-safe:animate-[squeeze_0.6s_ease-in-out]': !spin
        }" style="transform-origin: center" />
</svg>
