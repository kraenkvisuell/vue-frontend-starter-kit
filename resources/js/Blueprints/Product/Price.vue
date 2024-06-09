<script setup>
import { useModalStore } from '../../Stores/ModalStore.js'
import CartButton from './CartButton.vue'
import { useProductStore } from '../../Stores/ProductStore.js'

const productStore = useProductStore()
const modalStore = useModalStore()
</script>

<template>
    <div class="@container pt-[20px] sm:pt-0 px-[15px] sm:px-0">
        <div class="flex flex-col @md:flex-row gap-[30px] @md:gap-[12px] items-start @md:items-end justify-between">
            <div>
                <div class="text-headline-base md:text-headline-lg font-bold leading-none">
                    <span
                        v-for="sku in productStore.product.skus"
                        v-show="sku.id === productStore.selectedSkuId"
                        class="flex items-start"
                    >
                        <span>
                            {{ sku.dollars }},
                        </span>

                        <span class="text-copy-base sm:text-copy-lg mt-[1px] md:mt-[2px]">
                            {{ sku.cents }}&nbsp;{{ $shared.currencySign }}
                        </span>
                    </span>
                </div>

                <div class="text-copy-xs text-gray-800 tracking-normal mt-[0.4rem] sm:pr-[1.5rem] leading-[1rem]">
                    <div>{{ $trans.shop.incl_vat }} / {{ $trans.shop.free_shipping_in_eu }}</div>

                    <div>
                        <button class="underline" @click="modalStore.open('shippingExplanation')">
                            {{ $trans.shop.further_shipping_infos }}
                        </button>
                    </div>
                </div>
            </div>

            <button class="mb-[-5px]">
                <CartButton :product="productStore.product" />
            </button>
        </div>
    </div>
</template>
