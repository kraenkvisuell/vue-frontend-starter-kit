<script setup>
import Item from './Item.vue';
import { useOrderFormStore } from '../../../Stores/Merchants/OrderFormStore.js';
import Sku from './Sku.vue';
import ItemImageWrapper from './ItemImageWrapper.vue';
import ItemImage from './ItemImage.vue';
import ItemFlag from './ItemFlag.vue';

const orderFormStore = useOrderFormStore();

const props = defineProps({
    product: Object,
    productGroup: Object
});
</script>

<template>
    <Item
        v-show="orderFormStore.showProduct(product, productGroup)"
        @click="orderFormStore.toggleProduct(product.id)"
        class="bg-gray-200"
    >
        <div class="flex justify-between p-[5px]">
            <div class="pl-[3px]">
                <div v-text="product.title" />
                <div v-text="product.categories_string" class="text-copy-xs" />
            </div>

            <ItemImageWrapper>
                <ItemImage
                    v-for="image in orderFormStore.imagesForProduct(product)"
                    :image="image"
                />
            </ItemImageWrapper>
        </div>

        <template v-slot:flags>
            <ItemFlag v-if="orderFormStore.productContainsPreorder(product)" mode="alert">
                {{ $trans.shop.preorder }}
            </ItemFlag>

            <ItemFlag v-if="orderFormStore.productContainsNew(product)">
                {{ $trans.shop.new }}
            </ItemFlag>
        </template>
    </Item>

    <Sku v-for="sku in product.skus" :sku="sku" :product="product" :productGroup="productGroup" />
</template>
