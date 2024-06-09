<script setup>
import money from '../../money.js'
import Bag from '../../Parts/Menu/CartIcon/Bag.vue'
import Plus from '../../Parts/Menu/CartIcon/Plus.vue'
import {useCartStore} from '../../Stores/CartStore'
import {useShopStore} from '../../Stores/ShopStore.js'
import {computed} from 'vue'
import CheckMark from '../../Svg/CheckMark.vue'

const cartStore = useCartStore()
const shopStore = useShopStore()

const props = defineProps({
    product: {type: Object, default: {}},
})

const selectedSkuId = computed(() => shopStore.selectedSkuId[props.product.id])
</script>

<template>
    <button
        class="flex flex-row-reverse md:flex-row items-center pt-[18px] md:pt-0 transition-opacity duration-[800]"
        :class="{
            'opacity-40 pointer-events-none': cartStore.isBusy,
            'opacity-full pointer-events-auto': !cartStore.isBusy,
        }"
        :disabled="cartStore.isBusy"
        @click="cartStore.addItem(selectedSkuId, 1)"
    >
        <div
            v-for="sku in product.skus"
            class="whitespace-nowrap"
            :class="{
                'hidden': selectedSkuId !== sku.id,
            }"
        >
            {{ money.formatted(sku.price, 'de') }}&nbsp;{{ $shared.currencySign }}
        </div>

        <div class="
            fill-gray-800 relative cursor-pointer flex items-center justify-center
            h-icon w-[21px] mr-[0.5rem] md:mr-0 md:ml-[0.5rem]
        ">
            <div class="w-full h-full absolute top-0 left-0">
                <Bag/>
            </div>

            <div class="w-full h-full absolute top-0 left-0 grid justify-items-center items-center">
                <div class="h-[10px] mt-[2px]">
                    <CheckMark/>
                </div>
            </div>
        </div>
    </button>
</template>
