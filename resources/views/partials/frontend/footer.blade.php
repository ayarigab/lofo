<footer class="relative bg-slate-100 text-gray-900">
    <div class="absolute inset-0 h-full bottom-0 right-0 blur-xl z-10"
        style="background: linear-gradient(143.6deg, rgba(192, 132, 252, 0) 20.79%, rgba(32, 321, 259, 0.26) 40.92%, rgba(204, 171, 238, 0) 70.35%)">
    </div>
    <div class="max-w-6xl px-6 py-12 mx-auto relative z-20">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-400 uppercase">{{ __('lang_v1.about_us') }}</h3>
                <div class="flex space-x-6">
                    <p class="text-gray-600 text-sm text-justify">
                        Lost and Found is a community-driven platform dedicated to reuniting lost items with their
                        owners. Our mission is to make the process of finding lost belongings as simple and efficient as
                        possible, leveraging the power of community and technology.
                    </p>
                </div>
            </div>
            <div>
                <h3 class="mb-6 text-sm font-semibold uppercase text-gray-400">Company</h3>
                <ul class="space-y-2 hover:text-gray-500">
                    <li><a wire:navigate href="{{ route('about-us') }}" class="hover:text-black hover:underline transition-all">{{ __('lang_v1.about_us') }}</a></li>
                    <li><a wire:navigate href="{{ route('contact-us') }}" class="hover:text-black hover:underline transition-all">{{ __('lang_v1.contact_us') }}</a></li>
                    <li><a wire:navigate href="{{ route('about-us') }}" class="hover:text-black hover:underline transition-all">{{ __('lang_v1.careers') }}</a></li>
                    <li><a wire:navigate href="{{ route('about-us') }}" class="hover:text-black hover:underline transition-all">{{ __('lang_v1.press') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-400 uppercase">Resources</h3>
                <ul class="space-y-2">
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Help Center</a></li>
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Safety Tips</a></li>
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Community</a></li>
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Success Stories</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-400 uppercase">Legal</h3>
                <ul class="space-y-2">
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Privacy Policy</a></li>
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Terms of Service</a></li>
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">Cookie Policy</a></li>
                    <li><a wire:navigate href="#" class="hover:text-[#3B82F6] transition-colors">GDPR</a></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 mt-8 border-t border-slate-300 flex-row justify-between items-center">
            <div class="flex space-y-2 items-center">
                <p class="flex text-sm font-bold items-center m-0">
                    <x-app-logo-icon class="w-6 h-6" /> {{ __('lang_v1.lostfound') }} |
                </p>
                <p class="text-sm text-gray-600 ml-2">{{ __('lang_v1.copyright_text', ['year' => date('Y')]) }}
                </p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-[#3B82F6] transition-colors">
                    <span class="sr-only">Facebook</span>
                    <flux:icon.facebook class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-[#3B82F6] transition-colors">
                    <span class="sr-only">Twitter</span>
                    <flux:icon.twitter class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-[#3B82F6] transition-colors">
                    <span class="sr-only">Instagram</span>
                    <flux:icon.instagram class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-[#3B82F6] transition-colors">
                    <span class="sr-only">Slack</span>
                    <flux:icon.slack class="w-6 h-6" />
                </a>
                <a href="#" class="text-gray-400 hover:text-[#3B82F6] transition-colors">
                    <span class="sr-only">Slack</span>
                    <flux:icon.linkedin class="w-6 h-6" />
                </a>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset("libs/cookieconsent/cookieconsent.js") }}"></script>
<script src="{{ asset('libs/cookieconsent/cookieconsent-config.js') }}"></script>
@livewireScripts

@stack('scripts')
