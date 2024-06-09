<script setup>
import FooterWrapper from './Footer/FooterWrapper.vue'
import {useMerchantMenu} from '../Composables/useMerchantMenu'
import {Link} from '@inertiajs/vue3'

const {pages} = useMerchantMenu();
</script>

<template>
    <FooterWrapper>
        <div class="grid md:grid-cols-2 md:gap-[30px]">
            <div class="text-copy-sm editor">
                <div v-html="$shared.globals.merchants.general_help_text.text"/>
            </div>

            <div>
                <div v-for="page in pages" class="text-copy-sm">
                    <Link :href="page.url" class="underline" v-text="page.title"/>
                </div>
            </div>
        </div>
    </FooterWrapper>
</template>
