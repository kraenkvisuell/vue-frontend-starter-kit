<script setup>
import FooterWrapper from './Footer/FooterWrapper.vue'
import Navigations from './Footer/Navigations.vue'
import NewsletterForm from './Footer/NewsletterForm.vue'
import Seals from './Seals.vue'
import SocialMedia from './SocialMedia.vue'
import { usePaneStore } from '../Stores/PaneStore.js'
import { useStrings } from '../Composables/useStrings.js'

const { nl2br } = useStrings()

const paneStore = usePaneStore()
</script>

<template>
    <div>
        <Seals />

        <FooterWrapper>
            <div class="flex flex-col sm:flex-row gap-[50px]">
                <Navigations />

                <NewsletterForm />
            </div>

            <div class="
                w-full flex flex-col-reverse md:flex-row gap-[20px] justify-between md:items-end
                text-copy-sm tracking-normal text-gray-200 font-light
            ">
                <div class="pt-[40px]">
                    <div>
                        <button class="underline" @click="paneStore.open('cookieBannerPane')">
                            {{ $trans.shop.change_cookie_settings }}
                        </button>
                    </div>

                    <div v-html="nl2br($shared.globals.website.copyright.text)" />
                </div>

                <SocialMedia />
            </div>
        </FooterWrapper>
    </div>
</template>
