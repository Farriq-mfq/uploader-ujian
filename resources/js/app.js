import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "@vuepic/vue-datepicker/dist/main.css";
import "vue-toastification/dist/index.css";
import Toast from "vue-toastification";
import VueCountdown from "@chenfengyuan/vue-countdown";
createInertiaApp({
    title: (title) => `${title} - SIUP`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    progress: false,
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.config.globalProperties.$route = route;
        app.use(Toast, {});
        app.component(VueCountdown.name, VueCountdown);
        app.use(plugin).mount(el);
        app.config.devtools = false;
        app.config.debug = false;
        app.config.silent = true;
    },
});
