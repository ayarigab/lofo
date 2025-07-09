<footer class="relative bg-slate-100 text-gray-900">
    <div class="absolute inset-0 h-full bottom-0 right-0 blur-xl z-10"
        style="background: linear-gradient(143.6deg, rgba(192, 132, 252, 0) 20.79%, rgba(32, 321, 259, 0.26) 40.92%, rgba(204, 171, 238, 0) 70.35%)">
    </div>
    <div class="max-w-6xl px-6 py-12 mx-auto relative z-20">
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
