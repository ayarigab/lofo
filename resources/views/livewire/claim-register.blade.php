<div x-data="phoneInput">
    <form wire:submit.prevent="register" class="space-y-4 px-8 py-6 bg-white rounded-3xl shadow-xl">
        <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.your_name') }}</label>
            <input wire:model="full_name" type="text" id="full_name" required placeholder="{{ __('lang_v1.enter_full_name') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('full_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.email_address') }}{{ __('lang_v1.this_will_be_used_as_login') }}</label>
            <input wire:model="email" type="email" id="email" required placeholder="{{ __('lang_v1.enter_email_address') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.phone') }}</label>
            <input x-ref="phoneInput" wire:model="phone" type="tel" id="phone" required placeholder="{{ __('lang_v1.enter_phone_number') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.current_location') }}</label>
            <input wire:model="location" type="text" id="location" required placeholder="{{ __('lang_v1.enter_your_current_location') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('location') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="dob" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.dob') }}</label>
            <input wire:model="dob" type="date" id="dob" required max="{{ now()->toDateString() }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('dob') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.new_password') }}</label>
            <input wire:model="password" type="password" id="password" required placeholder="{{ __('lang_v1.choose_a_new_password') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.confirm_password') }}</label>
            <input wire:model="password_confirmation" type="password" id="password_confirmation" required
                placeholder="{{ __('lang_v1.confirm_your_password') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('lang_v1.user_photo') }}{{ __('lang_v1.required') }}</label>
            <div class="flex items-center space-x-4">
                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                    @if($previewAvatar)
                    <img src="{{ $previewAvatar }}" class="w-full h-full object-cover">
                    @else
                    <flux:icon name="image" class="w-10 h-10 text-gray-400 inline-block" />
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="avatar" wire:model="avatar" accept="image/*" class="hidden">
                    <label for="avatar"
                        class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <flux:icon name="image-up" class="w-5 h-5 inline-block mr-2" />
                        {{ __('lang_v1.choose_file') }}
                    </label>
                    @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" wire:loading.attr="disabled"
                class="w-full px-6 py-3 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all hover-scale disabled:opacity-50 disabled:cursor-not-wait">
                <span wire:loading.remove>{{ __('lang_v1.create_account') }}</span>
                <span wire:loading class="flex items-center justify-center">
                    <flux:icon name="loader-pinwheel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-whit inline-block" />
                    {{ __('lang_v1.processing') }}
                </span>
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                {{ __('lang_v1.already_have_an_account') }}
                <a href="{{ route('claimer-login') }}" class="font-medium text-black hover:text-gray-900">
                    {{ __('lang_v1.login_here') }}
                </a>
            </p>
        </div>
    </form>
</div>
