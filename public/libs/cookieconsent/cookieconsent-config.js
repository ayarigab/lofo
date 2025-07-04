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
        default: 'en',
        autoDetect: 'browser',
        rtl: 'ar',
        translations: {
            ar: {},
            de: {},
            en: {
                consentModal: {
                    title: 'Cookies consent',
                    description:
                        'This website uses cookies to deliver a smooth experience. By clicking <b>Allow</b>, you agree to the storing of cookies on your device to enhance site experience, analyze site usage, and assist in our marketing efforts. <a href="#link" style="text-decoration: underline;">Learn more</a>',
                    acceptAllBtn: 'Allow All',
                    acceptNecessaryBtn: 'Only Necessary',
                    showPreferencesBtn: 'Manage preference',
                    footer: '<a href="#link">Privacy Policy</a>\n<a href="#link">Terms and conditions</a>',
                },
                preferencesModal: {
                    title: '<svg class="fill-current text-gray-600 dark:text-gray-300" viewBox="0 0 1450 350" xmlns="http://www.w3.org/2000/svg"><path d="M286.33,180.13 L286.33,320.19 L239.51,320.19 L239.51,180.13 C239.51,166.87 237.02,154.3 232.05,142.42 C227.08,130.55 220.17,120.19 211.33,111.34 C202.49,102.5 192.2,95.53 180.46,90.41 C168.71,85.3 156.22,82.74 142.96,82.74 C129.7,82.74 116.85,85.3 105.25,90.41 C93.65,95.52 83.5,102.5 74.79,111.34 C66.09,120.18 59.25,130.54 54.28,142.42 C49.31,154.3 46.82,166.87 46.82,180.13 L46.82,320.19 L-2.78383965e-22,320.19 L-2.78383965e-22,180.13 C-2.78383965e-22,160.52 3.79,142.15 11.4,125.02 C18.99,107.89 29.28,92.98 42.27,80.27 C55.25,67.57 70.38,57.62 87.64,50.43 C104.9,43.25 123.34,39.66 142.96,39.66 C162.58,39.66 181.01,43.25 198.28,50.43 C215.54,57.62 230.74,67.56 243.86,80.27 C256.98,92.98 267.34,107.9 274.94,125.02 C282.53,142.15 286.34,160.52 286.34,180.13 L286.33,180.13 Z" id="n" fill="currentColor"></path><path d="M551.95,320.19 L551.95,277.09 C539.79,291.74 524.6,302.57 506.37,309.62 C488.14,316.66 469.76,320.19 451.26,320.19 C432.76,320.19 413.55,316.6 396.15,309.42 C378.75,302.24 363.48,292.29 350.36,279.58 C337.24,266.88 326.88,252.02 319.28,235.03 C311.68,218.04 307.88,199.74 307.88,180.12 C307.88,160.5 311.67,142.14 319.28,125.01 C326.87,107.88 337.23,92.97 350.36,80.26 C363.48,67.56 378.67,57.54 395.94,50.22 C413.2,42.9 431.64,39.24 451.26,39.24 C470.88,39.24 489.24,42.9 506.37,50.22 C523.5,57.54 538.55,67.56 551.54,80.26 C564.52,92.97 574.75,107.89 582.2,125.01 C589.66,142.14 593.39,160.51 593.39,180.12 L593.39,320.18 L551.95,320.18 L551.95,320.19 Z M451.25,81.92 C437.71,81.92 425.14,84.55 413.54,89.79 C401.94,95.04 391.71,102.16 382.88,111.13 C374.04,120.11 367.13,130.54 362.16,142.42 C357.19,154.3 354.7,166.87 354.7,180.13 C354.7,193.39 357.19,206.31 362.16,218.05 C367.13,229.8 373.97,240.08 382.67,248.92 C391.37,257.76 401.59,264.74 413.33,269.85 C425.07,274.96 437.71,277.52 451.25,277.52 C464.79,277.52 477.42,274.97 489.17,269.85 C500.91,264.74 511.06,257.77 519.63,248.92 C528.19,240.08 534.96,229.72 539.93,217.84 C544.9,205.97 547.39,193.39 547.39,180.13 C547.39,166.87 544.9,153.89 539.93,142.01 C534.96,130.14 528.18,119.78 519.63,110.93 C511.06,102.09 500.91,95.05 489.17,89.8 C477.42,84.56 464.79,81.93 451.25,81.93 L451.25,81.92 Z" id="a" fill="currentColor"></path><path d="M896.46,312.16 C883.47,299.46 873.26,284.55 865.8,267.41 C858.34,250.29 854.61,231.92 854.61,212.3 L854.61,188.54 C854.61,201.8 852.12,214.37 847.15,226.24 C842.18,238.12 835.41,248.48 826.85,257.32 C818.29,266.17 808.14,273.14 796.39,278.25 C784.65,283.37 772.01,285.91 758.47,285.91 C744.93,285.91 732.3,283.36 720.55,278.25 C708.81,273.14 698.59,266.17 689.89,257.32 C681.19,248.48 674.36,238.2 669.38,226.46 C664.41,214.72 661.92,202.08 661.92,188.54 C661.92,175 664.41,162.71 669.38,150.83 C674.35,138.96 681.25,128.53 690.09,119.55 C698.93,110.57 709.15,103.46 720.76,98.21 C732.36,92.97 744.93,90.34 758.46,90.34 C771.99,90.34 784.64,92.97 796.38,98.21 C808.12,103.46 818.27,110.5 826.84,119.34 C835.4,128.19 842.17,138.55 847.14,150.43 C852.11,162.3 854.6,175.01 854.6,188.55 L854.6,84.79 C842.58,73.91 828.9,65.2 813.57,58.65 C796.45,51.33 778.07,47.66 758.46,47.66 C738.85,47.66 720.4,51.33 703.14,58.65 C685.87,65.97 670.68,75.99 657.56,88.69 C644.43,101.4 634.08,116.32 626.48,133.45 C618.88,150.58 615.08,168.95 615.08,188.56 C615.08,208.17 618.87,226.48 626.48,243.46 C634.07,260.45 644.43,275.3 657.56,288.01 C670.68,300.72 685.95,310.66 703.35,317.84 C720.76,325.03 739.13,328.61 758.46,328.61 C777.79,328.61 795.35,325.08 813.57,318.04 C831.8,311 846.99,300.16 859.15,285.51 L859.15,359.61 L900.59,359.61 L900.59,316.06 C899.18,314.8 897.8,313.49 896.44,312.17 L896.46,312.16 Z" id="a" fill="currentColor"></path><path d="M1127.72,132.39 C1120.12,115.4 1109.76,100.56 1096.64,87.85 C1083.51,75.14 1068.25,65.2 1050.85,58.02 C1033.44,50.83 1015.06,47.25 995.74,47.25 C983.58,47.25 972.53,48.49 962.58,50.98 C952.64,53.46 943.52,56.78 935.23,60.92 C926.94,65.07 919.48,69.7 912.86,74.8 C906.22,79.92 900.28,85.09 895.03,90.34 L895.03,3.04040088e-23 L853.6,3.04040088e-23 L853.6,59.78 C855.01,61.04 856.39,62.35 857.75,63.67 C870.73,76.38 880.95,91.3 888.41,108.43 C895.87,125.56 899.6,143.93 899.6,163.54 L899.6,187.3 C899.6,174.04 902.09,161.47 907.05,149.59 C912.02,137.72 918.79,127.36 927.36,118.51 C935.91,109.67 946.06,102.7 957.82,97.58 C969.55,92.47 982.19,89.92 995.74,89.92 C1009.29,89.92 1021.9,92.48 1033.65,97.58 C1045.39,102.7 1055.62,109.67 1064.32,118.51 C1073.02,127.36 1079.85,137.64 1084.83,149.38 C1089.8,161.12 1092.29,173.76 1092.29,187.3 C1092.29,200.84 1089.8,213.13 1084.83,225 C1079.86,236.88 1073.03,247.31 1064.32,256.29 C1055.62,265.27 1045.39,272.38 1033.65,277.62 C1021.91,282.88 1009.27,285.5 995.74,285.5 C982.21,285.5 969.55,282.88 957.82,277.62 C946.07,272.38 935.92,265.34 927.36,256.49 C918.79,247.65 912.02,237.3 907.05,225.41 C902.09,213.54 899.6,200.82 899.6,187.29 L899.6,291.04 C911.61,301.93 925.29,310.64 940.63,317.19 C957.75,324.51 976.12,328.17 995.74,328.17 C1015.36,328.17 1033.79,324.51 1051.06,317.19 C1068.32,309.87 1083.51,299.85 1096.64,287.14 C1109.76,274.44 1120.11,259.53 1127.72,242.39 C1135.31,225.27 1139.12,206.9 1139.12,187.28 C1139.12,167.66 1135.32,149.36 1127.72,132.37 L1127.72,132.39 Z" id="b" fill="currentColor"></path><path d="M899.61,175.54 L899.61,303.05 C898.2,301.79 896.82,300.48 895.46,299.16 C882.47,286.46 872.26,271.55 864.8,254.41 C857.34,237.29 853.61,218.92 853.61,199.3 L853.61,71.78 C855.02,73.04 856.4,74.35 857.76,75.67 C870.74,88.38 880.96,103.3 888.42,120.43 C895.88,137.56 899.61,155.93 899.61,175.54 Z" id="leaf_break" fill="#44B04A"></path><path d="M1404.88,320.19 L1404.88,277.09 C1392.72,291.74 1377.53,302.57 1359.3,309.62 C1341.07,316.66 1322.69,320.19 1304.19,320.19 C1285.69,320.19 1266.48,316.6 1249.08,309.42 C1231.68,302.24 1216.41,292.29 1203.29,279.58 C1190.17,266.88 1179.81,252.02 1172.21,235.03 C1164.61,218.04 1160.81,199.74 1160.81,180.12 C1160.81,160.5 1164.6,142.14 1172.21,125.01 C1179.8,107.88 1190.16,92.97 1203.29,80.26 C1216.41,67.56 1231.6,57.54 1248.87,50.22 C1266.13,42.9 1284.57,39.24 1304.19,39.24 C1323.81,39.24 1342.17,42.9 1359.3,50.22 C1376.43,57.54 1391.48,67.56 1404.47,80.26 C1417.45,92.97 1427.68,107.89 1435.13,125.01 C1442.59,142.14 1446.32,160.51 1446.32,180.12 L1446.32,320.18 L1404.88,320.18 L1404.88,320.19 Z M1304.18,81.92 C1290.64,81.92 1278.07,84.55 1266.47,89.79 C1254.87,95.04 1244.64,102.16 1235.81,111.13 C1226.97,120.11 1220.06,130.54 1215.09,142.42 C1210.12,154.3 1207.63,166.87 1207.63,180.13 C1207.63,193.39 1210.12,206.31 1215.09,218.05 C1220.06,229.8 1226.9,240.08 1235.6,248.92 C1244.3,257.76 1254.52,264.74 1266.26,269.85 C1278,274.96 1290.64,277.52 1304.18,277.52 C1317.72,277.52 1330.35,274.97 1342.1,269.85 C1353.84,264.74 1363.99,257.77 1372.56,248.92 C1381.12,240.08 1387.89,229.72 1392.86,217.84 C1397.83,205.97 1400.32,193.39 1400.32,180.13 C1400.32,166.87 1397.83,153.89 1392.86,142.01 C1387.89,130.14 1381.11,119.78 1372.56,110.93 C1363.99,102.09 1353.84,95.05 1342.1,89.8 C1330.35,84.56 1317.72,81.93 1304.18,81.93 L1304.18,81.92 Z" id="a" fill="currentColor"></path></svg> Cookies Preferences',
                    acceptAllBtn: 'Allow All',
                    acceptNecessaryBtn: 'Only Necessary',
                    savePreferencesBtn: 'Save Current settings',
                    closeIconLabel: 'Close modal',
                    serviceCounterLabel: 'Service|Services',
                    sections: [
                        {
                            title: 'Cookie Usage',
                            description:
                                'When you visit any website, it may store or retrieve information on your browser, primarily in the form of cookies. This information might be about you, your preferences or your device and is mostly used to ensure the site functions as expected. While it typically does not directly identify you, it can provide a more personalized web experience. Because we respect your right to privacy, you can choose to disable certain types of cookies on our platform. Click on the different category headings to learn more and adjust your settings. However, blocking some types of cookies may impact your experience on this site and limit the services we offer.',
                        },
                        {
                            title: 'Strictly Necessary Cookies <span class="pm__badge">Necessary</span>',
                            description: `
                            These cookies are strictly necessary for the website to function and cannot be switched off in our systems.
                            They are usually set in response to actions made by you such as setting your privacy preferences, logging in,
                            or filling in forms. You can set your browser to block or alert you about these cookies, but some parts of the
                            site may not function properly without them.
                            `,
                            linkedCategory: 'necessary',
                        },
                        {
                            title: 'Functional Cookies',
                            description: `
                            Functional cookies enable enhanced functionality and personalization, such as remembering your login details,
                            language preferences, or region. These cookies may be set by us or by third-party providers whose services
                            we have integrated into our platform. Disabling these may result in reduced site functionality.
                            `,
                            linkedCategory: 'functionality',
                        },
                        {
                            title: 'Analytics & Performance Cookies',
                            description: `
                            These cookies help us understand how visitors interact with our website by collecting and reporting information
                            anonymously. We use tools like Google Analytics, Microsoft Clarity, and Mixpanel to measure
                            site performance, user engagement, and technical errors. This data helps us continuously improve your experience.
                            `,
                            linkedCategory: 'analytics',
                            cookieTable: {
                                headers: {
                                    name: 'Name',
                                    domain: 'Service',
                                    description: 'Description',
                                    expiration: 'Expiration',
                                },
                                body: [
                                    {
                                        name: '_ga',
                                        domain: 'Google Analytics',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://support.google.com/analytics/answer/11397207?hl=en">Google Analytics</a>.',
                                        expiration: 'Expires after 2 years',
                                    },
                                    {
                                        name: '_gid',
                                        domain: 'Google Analytics',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://support.google.com/analytics/answer/11397207?hl=en">Google Analytics</a>',
                                        expiration: 'Session',
                                    },
                                    {
                                        name: '_clck',
                                        domain: 'Clarity Analytics',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://learn.microsoft.com/en-us/clarity/setup-and-installation/cookie-list">Microsoft Clarity</a>',
                                        expiration: 'Session',
                                    },
                                    {
                                        name: '_clsk',
                                        domain: 'Clarity Analytics',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://learn.microsoft.com/en-us/clarity/setup-and-installation/cookie-list">Microsoft Clarity</a>',
                                        expiration: 'Session',
                                    },
                                    {
                                        name: 'hubspotutk',
                                        domain: 'Hobspot Analytics',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://knowledge.hubspot.com/privacy-and-consent/what-cookies-does-hubspot-set-in-a-visitor-s-browser">Hubspot</a>',
                                        expiration: 'Expires after 6 months.',
                                    },
                                    {
                                        name: '__hstc',
                                        domain: 'Hobspot Live Chat',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://knowledge.hubspot.com/privacy-and-consent/what-cookies-does-hubspot-set-in-a-visitor-s-browser">Hubspot</a>',
                                        expiration: 'Expires after 30 minutes.',
                                    },
                                    {
                                        name: '__hssrc',
                                        domain: 'Hobspot Live Chat',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://knowledge.hubspot.com/privacy-and-consent/what-cookies-does-hubspot-set-in-a-visitor-s-browser">Hubspot</a>',
                                        expiration: 'Session',
                                    },
                                    {
                                        name: '__hssc',
                                        domain: 'Hobspot Live Chat',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://knowledge.hubspot.com/privacy-and-consent/what-cookies-does-hubspot-set-in-a-visitor-s-browser">Hubspot</a>',
                                        expiration: 'Expires after 30 minutes.',
                                    },
                                    {
                                        name: 'messagesUtk',
                                        domain: 'Hobspot Live Chat',
                                        description:
                                            'Cookie set by <a target="_blank" href="https://knowledge.hubspot.com/privacy-and-consent/what-cookies-does-hubspot-set-in-a-visitor-s-browser">Hubspot</a>',
                                        expiration: 'Expires after 6 months',
                                    },
                                ],
                            },
                        },
                        {
                            title: 'Marketing & Tracking Cookies',
                            description: `
                            These cookies are used to deliver relevant advertising content based on your browsing behavior and to measure
                            the effectiveness of our marketing campaigns. They may be set by third-party advertising partners or integrated
                            platforms such as Mixpanel and Tawk.to. Disabling these cookies will not remove ads but may make them less relevant.
                            `,
                            linkedCategory: 'marketing',
                        },
                        {
                            title: 'Learn More',
                            description: `
                            To learn more about how Lost & Found System uses cookies and how we respect your data privacy, please
                            visit our <a class="cc__link" href="#">Cookie Policy</a> page.
                            `,
                        },
                    ],
                },
            },
            es: {},
            fr: {},
            it: {},
        },
    },
});
