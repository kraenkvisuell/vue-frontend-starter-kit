<script setup>
import ArticlesWrapper from './Cart/ArticlesWrapper.vue'
import CheckoutButton from './Cart/CheckoutButton.vue'
import MerchantArticle from './Cart/MerchantArticle.vue'
import MerchantDiscount from './Cart/MerchantDiscount.vue'
import MerchantInfoText from './Cart/MerchantInfoText.vue'
import MerchantOrderSum from './Cart/MerchantOrderSum.vue'
import MerchantShippingCosts from './Cart/MerchantShippingCosts.vue'
import MerchantSkuTotal from './Cart/MerchantSkuTotal.vue'
import MerchantTotalVat from './Cart/MerchantTotalVat.vue'
import SubtotalWithDiscount from './Cart/SubtotalWithDiscount.vue'
import SumsWrapper from './Cart/SumsWrapper.vue'
import {useCartPanelStore} from '../Stores/CartPanelStore'
import {useCartStore} from '../Stores/Merchants/CartStore'
import MerchantCartWrapper from './MerchantCartWrapper.vue'

const cartStore = useCartStore()
const cartPanelStore = useCartPanelStore()

const props = defineProps({
    context: {type: String, default: 'menu'},
})
</script>

<template>
    <MerchantCartWrapper>
        <ArticlesWrapper>
            <MerchantArticle v-for="sku in cartStore.currentCart.skus" :sku="sku"/>
        </ArticlesWrapper>

        <SumsWrapper>
            <MerchantSkuTotal v-if="cartStore.currentCart.discount"/>

            <MerchantDiscount v-if="cartStore.currentCart.discount"/>

            <SubtotalWithDiscount/>

            <MerchantShippingCosts/>

            <MerchantTotalVat/>

            <div class="mt-[16px]">
                <MerchantOrderSum/>
            </div>


            <div class="mt-[50px] grid gap-[30px]" v-if="context === 'menu'">
                <div
                    v-if="cartStore.isCloseToFree"
                    class="rounded border-2 text-error border-dashed border-error px-[15px] py-[10px]"
                    v-html="cartStore.closeToFreeMessage"
                />

                <a @click="cartPanelStore.close" :href="$route('merchants.checkout')">
                    <CheckoutButton/>
                </a>
            </div>

            <MerchantInfoText :context="context"/>
        </SumsWrapper>
    </MerchantCartWrapper>
</template>
