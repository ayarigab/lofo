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

        <div class="mb-4" x-data x-init="
            flatpickr($refs.dateInput, {
                altInput: true,
                locale: '{{ (app()->getLocale() === 'zh-CN') ? 'zh' : app()->getLocale() }}',
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: 'today'
            })">
            <label for="found_date" class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.found_date') }}</label>
            <input type="text" id="found_date" wire:model="found_date" x-ref="dateInput" placeholder="{{ __('lang_v1.select_date_found') }}"
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

        <div
            x-data="{
                cropOpen: false,
                currentField: null,
                currentIndex: null,
                cropper: null,

                initCropper(imageId, fieldName, index = null) {
                    this.currentField = fieldName;
                    this.currentIndex = index;
                    const image = document.getElementById(imageId);
                    const imageToCrop = document.getElementById('imageToCrop');

                    imageToCrop.onload = () => {
                        if (this.cropper) {
                            this.cropper.destroy();
                        }

                        this.cropper = new Cropper(imageToCrop, {
                            aspectRatio: NaN,
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            guides: false,
                            movable: true,
                            zoomable: true,
                            rotatable: true,
                            scalable: true,
                            center: true
                        });
                    };

                    imageToCrop.src = image.src;
                    this.cropOpen = true;
                },

                closeCropper() {
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.cropOpen = false;
                },

                async cropButton() {
                    if (this.cropper) {
                        const canvas = this.cropper.getCroppedCanvas({
                            width: 300,
                            height: 300,
                            minWidth: 256,
                            minHeight: 256,
                            maxWidth: 4096,
                            maxHeight: 4096,
                            fillColor: '#ffffff',
                            imageSmoothingEnabled: true,
                            imageSmoothingQuality: 'high',
                        });

                        canvas.toBlob((blob) => {
                            const file = new File([blob], 'cropped-image.webp', {
                                type: 'image/webp',
                            });

                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);

                            let input;
                            if (this.currentField === 'image') {
                                input = document.getElementById('image');
                            } else {
                                input = document.getElementById(`additional_image_${this.currentIndex}`);
                            }

                            if (input) {
                                input.files = dataTransfer.files;
                                const event = new Event('change', { bubbles: true });
                                input.dispatchEvent(event);
                            }

                            this.closeCropper();
                        }, 'image/webp', 0.9);
                    }
                },
            }">
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('lang_v1.image_upload') }}</label>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('lang_v1.main_photo') }}{{
                            __('lang_v1.required') }}</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center relative group">
                                @if($previewImage)
                                <img src="{{ $previewImage }}" class="w-24 h-24 object-cover rounded-2xl" id="main-preview">
                                <div
                                    x-data="{
                                        init() {
                                            initCropper('main-preview', 'image');
                                        }
                                    }"
                                    class="absolute inset-0 bg-white/10 rounded-2xl backdrop-blur-[2px] opacity-0 -translate-y-2 scale-95 ease-out duration-300 group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 transition-all flex items-center justify-center space-x-2">
                                    <button type="button"
                                        @click="cropOpen = true; initCropper('main-preview', 'image')"
                                        class="p-1 bg-white/70 rounded-full hover-scale">
                                        <flux:icon name="adjustments-horizontal" class="h-5 w-5" />
                                    </button>
                                    <button type="button" wire:click="$set('image', null)"
                                        class="p-1 bg-white/70 rounded-full hover-scale">
                                        <flux:icon name="trash" class="h-5 w-5" />
                                    </button>
                                </div>
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
                        <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('lang_v1.additional_photo') }}{{
                            __('lang_v1.optional') }}</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center relative group">
                                @if($additionalImg['field'] === 'image2' && $previewImage2)
                                <img src="{{ $previewImage2 }}" id="additional-preview-{{ $index }}"
                                    class="w-24 h-24 object-cover rounded-2xl">
                                <div
                                    x-data="{
                                        init() {
                                            initCropper('additional-preview-{{ $index }}', '{{ $additionalImg['field'] }}', {{ $index }});
                                        }
                                    }"
                                    class="absolute inset-0 bg-white/10 rounded-2xl backdrop-blur-[2px] opacity-0 -translate-y-2 scale-95 ease-out duration-300 group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 transition-all flex items-center justify-center space-x-2">
                                    <button type="button"
                                        @click="initCropper('additional-preview-{{ $index }}', '{{ $additionalImg['field'] }}', {{ $index }})"
                                        class="p-1 bg-white/70 rounded-full hover-scale">
                                        <flux:icon name="adjustments-horizontal" class="h-5 w-5" />
                                    </button>
                                    <button type="button" wire:click="removeAdditionalImage({{ $index }})"
                                        class="p-1 bg-white/70 rounded-full hover-scale">
                                        <flux:icon name="trash" class="h-5 w-5" />
                                    </button>
                                </div>
                                @elseif($additionalImg['field'] === 'image3' && $previewImage3)
                                <img src="{{ $previewImage3 }}" id="additional-preview-{{ $index }}"
                                    class="w-24 h-24 object-cover rounded-2xl">
                                <div
                                    x-data="{
                                        init() {
                                            initCropper('additional-preview-{{ $index }}', '{{ $additionalImg['field'] }}', {{ $index }});
                                        }
                                    }"
                                    class="absolute inset-0 bg-white/10 rounded-2xl backdrop-blur-[2px] opacity-0 -translate-y-2 scale-95 ease-out duration-300 group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 transition-all flex items-center justify-center space-x-2">
                                    <button type="button"
                                        @click="initCropper('additional-preview-{{ $index }}', '{{ $additionalImg['field'] }}', {{ $index }})"
                                        class="p-1 bg-white/70 rounded-full hover-scale">
                                        <flux:icon name="adjustments-horizontal" class="h-5 w-5" />
                                    </button>
                                    <button type="button" wire:click="removeAdditionalImage({{ $index }})"
                                        class="p-1 bg-white/70 rounded-full hover-scale">
                                        <flux:icon name="trash" class="h-5 w-5" />
                                    </button>
                                </div>
                                @else
                                <flux:icon name="image" class="w-10 h-10 text-gray-400 inline-block" />
                                @endif
                            </div>
                            <div class="flex-1 flex items-center space-x-2">
                                <input type="file" id="additional_image_{{ $index }}" wire:model="{{ $additionalImg['field'] }}"
                                    accept=".png, .jpg, .jpeg, .gif, .webp, .svg" class="hidden">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                            </path>
                        </svg>
                        {{ __('lang_v1.add_another_photo') }}
                    </button>
                </div>
            </div>

            <template x-teleport="body">
                <div x-show="cropOpen" class="fixed top-0 left-0 z-50 w-screen h-screen" x-cloak>
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="cropOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="cropButton()"
                            class="absolute inset-0 w-full h-full bg-white/10 backdrop-blur-sm bg-opacity-70">
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="cropOpen"
                            x-trap.inert.noscroll="cropOpen" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                            class="inline-block align-bottom bg-white rounded-3xl border text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ __('lang_v1.crop_image') }}</h3>
                                        <div class="mt-2">
                                            <div class="img-container">
                                                <img id="imageToCrop" src="" style="max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" @click="cropButton()"
                                    class="w-full inline-flex justify-center rounded-full hover-scale px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('lang_v1.save') }}
                                </button>
                                <button type="button"
                                    @click="cropButton()"
                                    class="w-full inline-flex justify-center rounded-full border hover-scale border-gray-400 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('lang_v1.cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
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
