<script setup>
import axios from 'axios'
import {onMounted, ref, watch} from 'vue'
import {storeToRefs} from 'pinia'
import {useCartStore} from '../../../Stores/Merchants/CartStore'
import {usePage} from '@inertiajs/vue3'

const stripe = Stripe(usePage().props.stripePublicKey)

const cartStore = useCartStore()
const {currentCart} = storeToRefs(cartStore)

const loadingStripe = ref(false)

let stripeCheckout = null

const loadStripe = async () => {
    loadingStripe.value = true

    const response = await axios.get(route('merchants.store.stripe-session'))

    const clientSecret = await response.data.stripeClientSecret

    loadingStripe.value = false

    if (stripeCheckout) {
        stripeCheckout.destroy()
    }

    stripeCheckout = await stripe.initEmbeddedCheckout({
        clientSecret,
    });

    stripeCheckout.mount('#stripeCheckout');
};

onMounted(() => {
    loadStripe()
})

watch(currentCart, () => {
    loadStripe()
})
</script>

<template>
    <div
        class="py-[40px] bg-white rounded-b"
        :class="{
            'opacity-40 pointer-events-none': loadingStripe,
        }"
    >
        <div id="stripeCheckout"></div>
    </div>
</template>
