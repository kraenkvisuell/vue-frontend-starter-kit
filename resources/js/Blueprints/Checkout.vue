<script setup>
import Address from './Checkout/Address.vue'
import CheckoutLogin from './Checkout/CheckoutLogin.vue'
import FormButton from '../Forms/FormButton.vue'
import HeadMeta from '../Parts/HeadMeta.vue'
import Hero from '../Parts/Hero.vue'
import OrderOverview from './Checkout/OrderOverview.vue'
import PageContainer from './Shared/PageContainer.vue'
import Section from '../Shared/Section.vue'
import { computed, watch } from 'vue'
import { useCartStore } from '../Stores/CartStore'
import { useCheckoutStore } from '../Stores/CheckoutStore.js'

const cartStore = useCartStore()
const checkoutStore = useCheckoutStore()

const entryForHero = computed(() => {
    let entry = $shared.globals.shop

    entry.title = $trans.shop.checkout
    entry.show_title = true
    return entry
})

const seoTitle = computed(() => {
    if ($shared.globals.shop.seo_title && $shared.globals.shop.seo_title.text) {
        return $shared.globals.shop.seo_title.text
    }

    return $shared.globals.shop.shop_title ? $shared.globals.shop.shop_title : 'Shop'
})

const ogTitle = computed(() => {
    if ($shared.globals.shop.og_title && $shared.globals.shop.og_title.text) {
        return $shared.globals.shop.og_title.text
    }

    return seoTitle.value
})

const seoDescription = computed(() => {
    if ($shared.globals.shop.seo_description && $shared.globals.shop.seo_description.text) {
        return $shared.globals.shop.seo_description.text
    }

    return $shared.globals.shop.shop_title ? $shared.globals.shop.shop_title : 'Shop'
})

const ogDescription = computed(() => {
    if ($shared.globals.shop.og_description && $shared.globals.shop.og_description.text) {
        return $shared.globals.shop.og_description.text
    }

    return seoDescription.value
})

const ogImage = computed(() => {
    if ($shared.globals.shop.og_image && $shared.globals.shop.og_image.is_image) {
        return $shared.globals.shop.og_image
    }

    return null
})

const twitterCardImage = computed(() => {
    if ($shared.globals.shop.twitter_card_image && $shared.globals.shop.twitter_card_image.is_image) {
        return $shared.globals.shop.twitter_card_image
    }

    return ogImage.value
})

watch(() => cartStore.currentCart, (newVal, oldVal) => {
    if (cartStore.currentCart.addressNeedsUpdating) {
        checkoutStore.openAddressForm()
    }
})
</script>

<template>
    <Suspense>
        <div>
            <HeadMeta
                :seoTitle="seoTitle"
                :ogTitle="ogTitle"
                :seoDescription="seoDescription"
                :ogDescription="ogDescription"
                :ogImage="ogImage"
                :twitterCardImage="twitterCardImage"
            />

            <Hero v-if="$shared.globals.shop.has_hero" :entry="entryForHero" />

            <PageContainer>
                <div v-show="cartStore.isLoaded" class="w-full pt-[40px] pb-[250px]">
                    <Section :hasMarginLeft="false" width="xl">
                        <div v-if="cartStore.currentCart.totalItems">
                            <div class="grid gap-[70px]">
                                <CheckoutLogin v-if="!$page.props.customerIsLogged" />

                                <Address class="scroll-mt-[160px]" />

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
                                <a :href="$route('shop', $shared.locale)" class="inline-block">
                                    <FormButton>
                                        {{ $trans.shop.continue_shopping }}
                                    </FormButton>
                                </a>
                            </div>
                        </div>
                    </Section>
                </div>
            </PageContainer>
        </div>
    </Suspense>
</template>

