<script setup>
import Account from '../Parts/Account.vue'
import BackToTop from '../Parts/BackToTop.vue'
import CookieBanner from '../Parts/CookieBanner.vue'
import FlashMessages from '../Parts/FlashMessages.vue'
import Footer from '../Parts/Footer.vue'
import Login from '../Parts/Login.vue'
import Menu from '../Parts/Menu.vue'
import Registration from '../Parts/Registration.vue'
import Search from '../Parts/Search.vue'
import { useCartStore } from '../Stores/CartStore'

const cartStore = useCartStore()

cartStore.loadCart()
</script>

<template>
    <main class="font-body text-black bg-gray-100">
        <header>
            <Menu />
        </header>

        <main>
            <slot />
        </main>

        <BackToTop />

        <footer>
            <Footer />
        </footer>

        <Search />

        <Login v-if="!$page.props.customerIsLogged" />

        <Registration v-if="!$page.props.customerIsLogged" />

        <Account v-if="$page.props.customerIsLogged" />

        <CookieBanner />

        <FlashMessages />
    </main>
</template>
