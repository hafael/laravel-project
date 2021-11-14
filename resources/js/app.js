require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Dinero from "dinero.js";
import Toaster from '@meforma/vue-toaster';
import VueTelInput from 'vue-tel-input'
import GlobalFilters from './filters';
import 'vue-tel-input/dist/vue-tel-input.css'
import mitt from 'mitt'
import Maska from 'maska'

const el = document.getElementById('app');
const eventBus = mitt();
const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
    })
    .mixin({ methods: { route } })
    .mixin(require('./trans'))
    .use(InertiaPlugin)
    .use(Toaster)
    .use(Maska)
    .use(VueTelInput, {
        mode: 'international',
        defaultCountry: 'BR',
        onlyCountries: ['BR'],
        enabledCountryCode: true,
        validCharactersOnly: true,
        dynamicPlaceholder: true,
        inputOptions: {
            placeholder: '+55 21 99999-9999'
        },
        maxlength: 20,
    });

//require('./filters');
app.config.globalProperties.$filters = GlobalFilters;
app.config.globalProperties.$bus = eventBus;
app.mount(el);

InertiaProgress.init({ color: '#4B5563' });
