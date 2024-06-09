<script setup>
import Layout from '../../Layouts/Merchants/Layout.vue'
import MerchantHero from '../../Parts/MerchantHero.vue'
import PageContainer from '../Shared/PageContainer.vue'
import PageMain from '../../Shared/PageMain.vue'
import {Head, usePage} from '@inertiajs/vue3'
import BlockYMargin from '../../Shared/BlockYMargin.vue'
import {computed} from 'vue'

defineOptions({layout: Layout})

//console.log($shared.globals)

const successText = computed(() => {
    if (usePage().props.paymentKind === 'stripe') {
        return $shared.globals.shop.stripe_success_page.text
    }

    return $shared.globals.shop.prepayment_success_page.text
})
</script>

<template>
    <Head :title="$shared.websiteName+' | '+$trans.shop.merchants+' | Vielen Dank für Ihre Bestellung'"/>

    <MerchantHero title="Ihre Bestellung"/>

    <PageContainer>
        <PageMain>
            <BlockYMargin>
                <div class="editor" v-html="successText"/>
            </BlockYMargin>
        </PageMain>
    </PageContainer>
</template>
