<div class="bg-slate-100 rounded-3xl p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full border {{ $borderColor }} mr-4">
            <flux:icon name="{{ $icon }}" class="w-6 h-6 {{ $color }}" />
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-semibold text-gray-800">{{ $value }}</p>
        </div>
    </div>
</div>
