<script setup>
import FormButton from '../../Forms/FormButton.vue'
import Layout from '../../Layouts/Merchants/Layout.vue'
import MerchantHero from '../../Parts/MerchantHero.vue'
import OrderOverview from './Checkout/OrderOverview.vue'
import PageContainer from '../Shared/PageContainer.vue'
import Section from '../../Shared/Section.vue'
import {Head} from '@inertiajs/vue3'
import {watch} from 'vue'
import {useCartStore} from '../../Stores/Merchants/CartStore'
import {useCheckoutStore} from '../../Stores/Merchants/CheckoutStore.js'

const cartStore = useCartStore()
const checkoutStore = useCheckoutStore()

defineOptions({layout: Layout})

watch(() => cartStore.currentCart, (newVal, oldVal) => {
    if (cartStore.currentCart.addressNeedsUpdating) {
        checkoutStore.openAddressForm()
    }
})
</script>

<template>
    <Head :title="$shared.websiteName+' | '+$trans.shop.checkout"/>

    <MerchantHero :title="$trans.shop.checkout"/>

    <PageContainer>
        <div v-show="cartStore.isLoaded" class="w-full pt-[40px] pb-[120px]">
            <Section width="xl">
                <div v-if="cartStore.currentCart.totalItems">
                    <div class="grid gap-[70px]">
                        <OrderOverview
                            class="scroll-mt-[160px]"
                            v-show="!checkoutStore.addressFormIsOpen"
                        />
                    </div>
                </div>

                <div v-else class="grid gap-[40px]">
                    <div>
                        {{ $trans.shop.no_articles_in_cart }}
                    </div>

                    <div>
                        <a :href="$route('merchants.order-form')" class="inline-block">
                            <FormButton>
                                {{ $trans.shop.continue_shopping }}
                            </FormButton>
                        </a>
                    </div>
                </div>
            </Section>
        </div>
    </PageContainer>
</template>

