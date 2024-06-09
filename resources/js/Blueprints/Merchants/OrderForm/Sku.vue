<script setup>
import { usePage } from '@inertiajs/vue3';
import money from '../../../money.js';
import Item from './Item.vue';
import ItemFlag from './ItemFlag.vue';
import ItemImage from './ItemImage.vue';
import ItemImageWrapper from './ItemImageWrapper.vue';
import SkuQuantity from './SkuQuantity.vue';
import { computed } from 'vue';
import { useOrderFormModalsStore } from '../../../Stores/Merchants/OrderFormModalsStore.js';
import { useOrderFormStore } from '../../../Stores/Merchants/OrderFormStore.js';

const orderFormStore = useOrderFormStore();
const orderFormModalsStore = useOrderFormModalsStore();

const props = defineProps({
    sku: Object,
    product: Object,
    productGroup: Object
});

const actualColor = computed(() => {
    return props.sku.colors.length ? props.sku.colors[0].rgb : { value: '#fefefe' };
});

// console.log(props.sku)
</script>

<template>
    <Item
        v-show="orderFormStore.showSku(sku, product, productGroup)"
        class="bg-white h-[80px]"
    >

        <div class="flex h-full">
            <button
                @click="orderFormModalsStore.open(sku, product)"
                class="flex items-end justify-center w-[22px] h-full flex-grow-0"
                :style="{backgroundColor: actualColor}"
            >
                <div class="text-white font-bold text-copy-lg">i</div>
            </button>

            <div class="w-full flex-grow-1 flex justify-between items-stretch">
                <div class="px-[8px] py-[5px]">
                    <div v-text="sku.title" />

                    <div v-if="usePage().props.loggedMerchant.can_see_prices">
                        {{ money.formatted(sku.price, 'de') }}&nbsp;{{ $shared.currencySign }}
                    </div>
                </div>

                <div class="flex gap-[20px] mr-[10px]">
                    <ItemImageWrapper>
                        <ItemImage v-if="sku.image" :image="sku.image" />
                    </ItemImageWrapper>

                    <SkuQuantity :sku="sku" />
                </div>
            </div>
        </div>

        <template v-slot:flags>
            <ItemFlag v-if="sku.is_preorder" mode="alert">
                {{ $trans.shop.preorder }}
            </ItemFlag>

            <ItemFlag v-if="sku.is_new">
                {{ $trans.shop.new }}
            </ItemFlag>
        </template>
    </Item>
</template>
