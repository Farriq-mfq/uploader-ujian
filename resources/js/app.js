import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "@vuepic/vue-datepicker/dist/main.css";
import "vue-toastification/dist/index.css";
import Toast from "vue-toastification";
import moment from "moment";
createInertiaApp({
    // title: (title) => `${title} - UPT KOM`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    progress: {
        color: "#29d",
        showSpinner: true,
    },
    setup({ el, App, props, plugin }) {
        moment.locale("id");
        const app = createApp({ render: () => h(App, props) });
        app.config.globalProperties.$route = route;
        const options = {
            // You can set your default options here
        };
        app.use(Toast, options);
        app.use(plugin).mount(el);
    },
});
