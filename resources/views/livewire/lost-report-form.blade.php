<div x-data="phoneInput">
    <form wire:submit.prevent="submit" class="p-8 bg-white rounded-3xl shadow-xl">
        <div class="mb-4">
            <label for="full_name" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.your_name') }}</label>
            <input type="text" id="full_name" wire:model="full_name"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_full_name') }}" />
            @error('full_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.email_address') }}</label>
            <input type="email" id="email" wire:model="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_email_address') }}" />
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.phone') }}</label>
            <input type="tel" id="phone" x-ref="phoneInput" wire:model="phone"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_phone_number') }}" />
                @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

        <div class="mb-4">
            <label for="items_lost" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.items_lost') }}</label>
            <input type="text" id="items_lost" wire:model="items_lost"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_name_of_items_lost') }}" />
            @error('items_lost') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4" x-data
            x-init="
            flatpickr($refs.dateInput, {
                altInput: true,
                locale: '{{ (app()->getLocale() === 'zh-CN') ? 'zh' : app()->getLocale() }}',
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: 'today'
            })">
            <label for="lost_date" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.date_lost') }}{{ __('lang_v1.optional') }}</label>
            <input type="text" id="lost_date" wire:model="lost_date" x-ref="dateInput" placeholder="{{ __('lang_v1.select_date_lost') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]" />
            @error('lost_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="lost_location" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.lost_location') }}{{ __('lang_v1.optional') }}</label>
            <input type="text" id="lost_location" wire:model="lost_location"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.lost_location_where_lost') }}" />
            @error('lost_location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.description') }}</label>
            <textarea id="description" wire:model="description" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-3xl focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.describe_the_items') }}"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="w-full px-6 py-3 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all hover-scale">
            {{ __('lang_v1.submit_report') }}
        </button>
    </form>
</div>
