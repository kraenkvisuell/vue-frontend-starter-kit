<script setup>
import BackToTop from '../../Parts/BackToTop.vue'
import FlashMessages from '../../Parts/FlashMessages.vue'
import MerchantAccount from '../../Parts/MerchantAccount.vue'
import MerchantMenu from '../../Parts/MerchantMenu.vue'
import {useCartStore} from '../../Stores/Merchants/CartStore.js'
import MerchantFooter from '../../Parts/MerchantFooter.vue'

const cartStore = useCartStore()

cartStore.loadCart()
</script>

<template>
    <main class="font-body text-black bg-gray-100">
        <header>
            <MerchantMenu/>
        </header>

        <main>
            <slot/>
        </main>

        <BackToTop/>

        <footer>
            <MerchantFooter/>
        </footer>

        <MerchantAccount/>

        <FlashMessages/>
    </main>
</template>
