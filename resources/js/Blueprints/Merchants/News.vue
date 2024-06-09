<script setup>
import Layout from '../../Layouts/Merchants/Layout.vue'
import PageContainer from '../Shared/PageContainer.vue'
import PageMain from '../../Shared/PageMain.vue'
import {Head} from '@inertiajs/vue3'
import BlockYMargin from '../../Shared/BlockYMargin.vue'
import MerchantHero from '../../Parts/MerchantHero.vue'

defineOptions({layout: Layout})
</script>

<template>
    <Head :title="$shared.websiteName+' | '+$trans.shop.merchants+' | '+$trans.shop.news"/>

    <MerchantHero :title="$trans.shop.news"/>

    <div id="maincontent" class="scroll-mt-[120px]">
        <PageContainer>
            <PageMain>
                <BlockYMargin>
                    News
                </BlockYMargin>
            </PageMain>
        </PageContainer>
    </div>
</template>
