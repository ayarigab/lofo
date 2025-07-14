<script>
CookieConsent.run({
    guiOptions: {
        consentModal: {
            layout: 'box wide',
            position: 'bottom left',
            equalWeightButtons: false,
            flipButtons: true,
        },
        preferencesModal: {
            layout: 'box',
            position: 'right',
            equalWeightButtons: false,
            flipButtons: true,
        },
    },
    debug: false,
    categories: {
        necessary: {
            readOnly: true,
        },
        functionality: {
            enabled: true,
        },
        analytics: {
            readOnly: true,
            enabled: true,
        },
        marketing: {
            enabled: true,
        },
    },
    language: {
        default: '{{ (app()->getLocale() === 'zh-CN') ? 'zh' : app()->getLocale() }}',
        rtl: ['ar', 'fa'],
        translations: {
            ar: "{{ assetV('libs/cookieconsent/cc-langs/ar.json') }}",
            de: "{{ assetV('libs/cookieconsent/cc-langs/de.json') }}",
            en: "{{ assetV('libs/cookieconsent/cc-langs/en.json') }}",
            es: "{{ assetV('libs/cookieconsent/cc-langs/es.json') }}",
            fr: "{{ assetV('libs/cookieconsent/cc-langs/fr.json') }}",
            it: "{{ assetV('libs/cookieconsent/cc-langs/it.json') }}",
            fa: "{{ assetV('libs/cookieconsent/cc-langs/fa.json') }}",
            pt: "{{ assetV('libs/cookieconsent/cc-langs/pt.json') }}",
            ru: "{{ assetV('libs/cookieconsent/cc-langs/ru.json') }}",
            zh: "{{ assetV('libs/cookieconsent/cc-langs/zh.json') }}",
            hi: "{{ assetV('libs/cookieconsent/cc-langs/hi.json') }}",
            ha: "{{ assetV('libs/cookieconsent/cc-langs/ha.json') }}",
            vi: "{{ assetV('libs/cookieconsent/cc-langs/vi.json') }}",
        },
    },
});
</script>
