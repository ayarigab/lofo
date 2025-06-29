<div x-data="phoneInput">
    <form wire:submit.prevent="submit" class="p-8 bg-white rounded-3xl shadow-xl" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="category_id" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.item_category') }}</label>
            <select id="category_id" wire:model="category_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]">
                <option value="">{{ __('lang_v1.select_a_category') }}</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.item_title') }}</label>
            <input type="text" id="title" wire:model="title"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.brief_item_title') }}">
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4 flex items-center">
            <div class="w-full mr-2">
                <label for="brand" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.item_brand') }}{{ __('lang_v1.optional') }}</label>
                <input type="text" id="brand" wire:model="brand"
                    class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                    placeholder="{{ __('lang_v1.enter_brand_of_items') }}">
                @error('brand') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="w-full ml-2">
                <label for="color" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.item_color') }}{{ __('lang_v1.optional') }}</label>
                <input type="text" id="color" wire:model="color"
                    class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                    placeholder="{{ __('lang_v1.specify_color_of_item') }}">
                @error('color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="model" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.item_model') }}{{ __('lang_v1.optional') }}</label>
            <input type="text" id="model" wire:model="model"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_item_model') }}">
            @error('model') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.detailed_description') }}</label>
            <textarea id="description" wire:model="description" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-3xl focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.provide_detailed_description') }}"></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="found_location" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.found_location') }}</label>
            <input type="text" id="found_location" wire:model="found_location"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.where_was_the_item_found') }}">
            @error('found_location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="found_date" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.found_date') }}</label>
            <input type="date" id="found_date" wire:model="found_date" max="{{ now()->toDateString() }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]">
            @error('found_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="founder_name" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.founder_name') }}</label>
            <input type="text" id="founder_name" wire:model="founder_name"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_founder_name') }}">
            @error('founder_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="founder_email" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.founder_email') }}</label>
            <input type="email" id="founder_email" wire:model="founder_email"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_founder_email') }}">
            @error('founder_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="founder_phone" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.founder_phone') }}</label>
            <input x-ref="phoneInput" id="phone" wire:model="founder_phone" placeholder="{{ __('lang_v1.enter_founder_phone') }}" type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]">
            @error('founder_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="founder_address" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.founder_address') }}{{ __('lang_v1.optional') }}</label>
            <input type="text" id="founder_address" wire:model="founder_address"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="{{ __('lang_v1.enter_founder_address') }}">
            @error('founder_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.image_upload') }}</label>
            <div class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('lang_v1.main_photo') }}{{ __('lang_v1.required') }}</label>
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                            @if($previewImage)
                            <img src="{{ $previewImage }}" class="w-24 h-24 object-cover rounded-lg">
                            @else
                            <flux:icon name="image" class="w-10 h-10 text-gray-400 inline-block" />
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" id="image" wire:model="image" accept="image/*" class="hidden">
                            <label for="image"
                                class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover-scale">
                                <flux:icon name="image-up" class="w-5 h-5 inline-block mr-2 text-gray-500" />
                                {{ __('lang_v1.choose_file') }}
                            </label>
                            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                @foreach($additionalImages as $index => $additionalImg)
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('lang_v1.additional_photo') }}{{ __('lang_v1.optional') }}</label>
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                            @if($additionalImg['field'] === 'image2' && $previewImage2)
                            <img src="{{ $previewImage2 }}" class="w-24 h-24 object-cover rounded-lg">
                            @elseif($additionalImg['field'] === 'image3' && $previewImage3)
                            <img src="{{ $previewImage3 }}" class="w-24 h-24 object-cover rounded-lg">
                            @else
                            <flux:icon name="image" class="w-10 h-10 text-gray-400 inline-block" />
                            @endif
                        </div>
                        <div class="flex-1 flex items-center space-x-2">
                            <input type="file" id="additional_image_{{ $index }}"
                                wire:model="{{ $additionalImg['field'] }}" accept="image/*" class="hidden">
                            <label for="additional_image_{{ $index }}"
                                class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover-scale">
                                <flux:icon name="image-up" class="w-5 h-5 inline-block mr-2" />
                                {{ __('lang_v1.choose_file') }}
                            </label>
                            <button wire:click="removeAdditionalImage({{ $index }})" type="button"
                                class="text-red-500 hover:text-red-700 hover-scale">
                                <flux:icon name="trash" class="w-5 h-5 inline-block" />
                                {{ __('lang_v1.remove') }}
                            </button>
                        </div>
                    </div>
                    @error($additionalImg['field']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                @endforeach

                <button wire:click="addAdditionalImage" type="button" @if(count($additionalImages)>= 2) disabled @endif
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium
                    text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2
                    focus:ring-blue-500 disabled:opacity-50 hover-scale">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('lang_v1.add_another_photo') }}
                </button>
            </div>
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="w-full px-6 py-3 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all hover-scale disabled:opacity-50 disabled:cursor-not-wait">
            <span wire:loading.remove>{{ __('lang_v1.report_found_item') }}</span>
            <span wire:loading class="flex items-center justify-center">
                <flux:icon name="loader-pinwheel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-whit inline-block" />
                {{ __('lang_v1.processing') }}
            </span>
        </button>
    </form>
</div>
