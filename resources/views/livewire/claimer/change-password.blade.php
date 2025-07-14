<form wire:submit.prevent="updatePassword" class="space-y-4 text-start">
    <div class="mb-6">
        <label for="current_password" class="block text-sm font-medium text-gray-700">
            {{ __('lang_v1.current_password') }}
        </label>
        <input wire:model="current_password" type="password" id="current_password" required
            placeholder="{{ __('lang_v1.enter_current_password') }}"
            class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

        @error('current_password')
        <span class="text-xs text-red-500">
            {{ __($message) }}
            @if($remainingAttempts > 0)
            {{ __('lang_v1.attempts_remaining') }} {{ $remainingAttempts }}
            @endif
        </span>
        @enderror
    </div>
    <div class="mb-6">
        <label for="new_password" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.new_password')
            }}</label>
        <input wire:model="new_password" type="password" id="new_password" required
            placeholder="{{ __('lang_v1.choose_a_new_password') }}"
            class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('new_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
    </div>
    <div class="mb-6">
        <label for="confirm_password" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.confirm_password')
            }}</label>
        <input wire:model="confirm_password" type="password" id="confirm_password" required
            placeholder="{{ __('lang_v1.confirm_your_password') }}"
            class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('confirm_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
    </div>
    <button type="submit"
        class="hover-scale inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-full bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">
        {{ __('lang_v1.update_password') }}
    </button>
</form>
