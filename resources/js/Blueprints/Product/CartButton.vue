<script setup>
import Bag from '../../Parts/Menu/CartIcon/Bag.vue'
import CheckMark from '../../Svg/CheckMark.vue'
import FormButton from '../../Forms/FormButton.vue'
import Mail from '../../Svg/Mail.vue'
import { computed } from 'vue'
import { useCartStore } from '../../Stores/CartStore'
import { useProductStore } from '../../Stores/ProductStore.js'
import { useModalStore } from '../../Stores/ModalStore.js'

const props = defineProps({
    product: Object,
})

const productStore = useProductStore()
const cartStore = useCartStore()
const modalStore = useModalStore()

const handleClick = () => {
    if (productStore.selectedSku.is_available) {
        cartStore.addItem(productStore.selectedSkuId, 1)
    } else {
        modalStore.open('messageWhenAvailableModal')
    }
}

let bgColor = computed(() => {
    return productStore.selectedSkuId && props.product
        ? props.product.skus.find(sku => sku.id === productStore.selectedSkuId).colors[0].rgb
        : ''
})
</script>

<template>
    <button :disabled="cartStore.isBusy" @click="handleClick">
        <FormButton :bgColor="bgColor" :disabled="cartStore.isBusy">
            <div class="
                relative cursor-pointer flex items-center justify-center
                h-icon w-[21px] -mt-[2px] -ml-[2px] mr-[10px]
            ">
                <div v-if="productStore.selectedSku.is_available" class="w-full h-full absolute top-0 left-0">
                    <Bag />
                </div>


                <div v-if="productStore.selectedSku.is_available" class="w-[40%] absolute top-[36%] left-[30%]">
                    <CheckMark />
                </div>

                <div v-if="!productStore.selectedSku.is_available" class="h-[76%] mt-[12%]">
                    <Mail />
                </div>
            </div>

            <div v-if="productStore.selectedSku.is_available" class="whitespace-nowrap text-copy-xs sm:text-copy-base">
                {{ $trans.shop.put_in_cart }}
            </div>

            <div v-if="!productStore.selectedSku.is_available" class="text-copy-xs text-left leading-tight">
                <span class="whitespace-nowrap">{{ $trans.shop.unavailable_at_the_moment }} –</span><br>
                <span class="whitespace-nowrap">{{ $trans.shop.message_when_available_again }}</span>
            </div>
        </FormButton>
    </button>
</template>
