<script setup>
import Item from './Item.vue'
import ItemFlag from './ItemFlag.vue'
import ItemImage from './ItemImage.vue'
import ItemImageWrapper from './ItemImageWrapper.vue'
import Product from './Product.vue'
import { useOrderFormStore } from '../../../Stores/Merchants/OrderFormStore'

const orderFormStore = useOrderFormStore()

const props = defineProps({
    productGroup: Object,
})
</script>

<template>
    <div>
        <Item
            v-show="orderFormStore.showProductGroup(productGroup)"
            class="bg-gray-300"
            @click="orderFormStore.toggleProductGroup(productGroup.id)"
        >
            <div class="w-full flex justify-between p-[5px]">
                <div class="pl-[3px]">
                    <div v-text="productGroup.title" />
                    <div v-text="productGroup.categories_string" class="text-copy-xs" />
                </div>

                <ItemImageWrapper>
                    <ItemImage
                        v-for="image in orderFormStore.imagesForProductGroup(productGroup)"
                        :image="image"
                    />
                </ItemImageWrapper>
            </div>

            <template v-slot:flags>
                <ItemFlag v-if="orderFormStore.productGroupContainsPreorder(productGroup)" mode="alert">
                    {{ $trans.shop.preorder }}
                </ItemFlag>

                <ItemFlag v-if="orderFormStore.productGroupContainsNew(productGroup)">
                    {{ $trans.shop.new }}
                </ItemFlag>
            </template>
        </Item>

        <Product v-for="product in productGroup.products" :product="product" :productGroup="productGroup" />
    </div>
</template>
