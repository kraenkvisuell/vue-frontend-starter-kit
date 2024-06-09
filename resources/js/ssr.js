import '@twicpics/components/style.css'
import Layout from './Layouts/Layout.vue'
import TwicPics from '@twicpics/components/vue3'
import createServer from '@inertiajs/vue3/server'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'

const pinia = createPinia()

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        progress: {
            color: '#9FC141',
        },
        title: (title) => `${title}`,
        resolve: name => {
            const pages = import.meta.glob('./Blueprints/**/*.vue', { eager: true })
            let page = pages[`./Blueprints/${name}.vue`]
            page.default.layout = page.default.layout || Layout
            return page
        },

        setup({ el, App, props, plugin }) {
            const VueApp = createSSRApp({ render: () => h(App, props) })
            VueApp.config.globalProperties.$route = route
            VueApp.config.globalProperties.$trans = $trans
            VueApp.config.globalProperties.$shared = $shared
            VueApp.use(plugin)
            .use(pinia)
            .use(TwicPics, {
                domain: 'https://zwei-bags.twic.pics',
            })
            .mount(el)
        },
    }),
)
