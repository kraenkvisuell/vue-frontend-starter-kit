<script setup>
import Filters from './OrderForm/Filters.vue';
import Layout from '../../Layouts/Merchants/Layout.vue';
import MerchantHero from '../../Parts/MerchantHero.vue';
import PageContainer from '../Shared/PageContainer.vue';
import PageMain from '../../Shared/PageMain.vue';
import ProductGroup from './OrderForm/ProductGroup.vue';
import ProductInfo from '../../Modals/Merchants/ProductInfo.vue';
import _ from 'lodash';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useOrderFormStore } from '../../Stores/Merchants/OrderFormStore.js';

const orderFormStore = useOrderFormStore();

defineOptions({ layout: Layout });

const startOfSecondBatch = computed(() => {
    return parseInt(_.size(usePage().props.productGroups) / 2) + 1;
});

const firstBatch = computed(() => {
    return _.take(usePage().props.productGroups, startOfSecondBatch.value - 1);
});

const secondBatch = computed(() => {
    return _.slice(usePage().props.productGroups, startOfSecondBatch.value - 1);
});
</script>

<template>
    <Head :title="$shared.websiteName+' | '+$trans.shop.merchants+' | '+$trans.shop.order_form" />

    <MerchantHero :title="$trans.shop.order_form" />

    <div id="maincontent" class="scroll-mt-[120px]">
        <PageContainer>
            <PageMain>
                <div class="max-w-screen-lg mx-auto pt-[40px] grid gap-[40px]">
                    <div>
                        <Filters />
                    </div>

                    <div class="md:grid md:grid-cols-2 md:gap-[30px]">
                        <div>
                            <ProductGroup
                                v-for="productGroup in firstBatch"
                                :productGroup="productGroup"
                            />
                        </div>

                        <div>
                            <ProductGroup
                                v-for="productGroup in secondBatch"
                                :productGroup="productGroup"
                            />
                        </div>
                    </div>
                </div>
            </PageMain>
        </PageContainer>
    </div>

    <ProductInfo />
</template>
