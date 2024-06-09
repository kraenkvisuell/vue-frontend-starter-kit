<script setup>
import Article from './Cart/Article.vue'
import ArticlesWrapper from './Cart/ArticlesWrapper.vue'
import CheckoutButton from './Cart/CheckoutButton.vue'
import InfoText from './Cart/InfoText.vue'
import SumsWrapper from './Cart/SumsWrapper.vue'
import CartWrapper from './CartWrapper.vue'
import OrderSum from './Cart/OrderSum.vue'
import ShippingCosts from './Cart/ShippingCosts.vue'
import Subtotal from './Cart/Subtotal.vue'
import VoucherCodes from './Cart/VoucherCodes.vue'
import {useCartPanelStore} from '../Stores/CartPanelStore'
import {useCartStore} from '../Stores/CartStore'

const cartStore = useCartStore()
const cartPanelStore = useCartPanelStore()

const props = defineProps({
    context: {type: String, default: 'menu'},
})
</script>


<template>
    <CartWrapper :context="context">
        <ArticlesWrapper>
            <Article v-for="sku in cartStore.currentCart.skus" :sku="sku"/>
        </ArticlesWrapper>

        <SumsWrapper>
            <Subtotal/>

            <ShippingCosts/>

            <VoucherCodes/>

            <div class="mt-[16px]">
                <OrderSum/>
            </div>

            <template v-if="context === 'menu'" v-slot:checkout-button>
                <a @click="cartPanelStore.close" :href="$route('checkout', $shared.locale)">
                    <CheckoutButton/>
                </a>
            </template>
        </SumsWrapper>

        <InfoText :context="context"/>
    </CartWrapper>
</template>
