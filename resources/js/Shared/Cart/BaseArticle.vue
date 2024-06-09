<script setup>
import Close from '../Close.vue'
import SelectField from '../../Forms/SelectField.vue'
import money from '../../money.js'
import { computed, ref, watch } from 'vue'
import { useMedia } from '../../Composables/useMedia.js'

const { imageLink } = useMedia()

const props = defineProps({
    sku: Object,
    minQuantityOptions: Number,
    cartStore: Object,
})

const quantity = computed(() => props.sku.quantity)

const quantityOptions = computed(() => {
    let options = []
    let max = props.sku.quantity > props.minQuantityOptions ? props.sku.quantity : props.minQuantityOptions
    for (let i = 1; i <= max; i++) {
        options.push({ value: i, label: i })
    }
    return options
})

const localQuantity = ref(quantity.value)

watch(quantity, async (newQuantity) => {
    localQuantity.value = newQuantity
})

watch(localQuantity, async (newQuantity) => {
    if (newQuantity !== quantity.value) {
        props.cartStore.changeItemQuantity(props.sku, newQuantity)
    }
})
</script>

<template>
    <div class="bg-white p-[8px] flex gap-[20px]">
        <div class="w-[100px] xl:w-[150px]">
            <img :src="imageLink(sku.image, { fit: [800, 800] })" />
        </div>

        <div>
            <div class="text-copy-xs">
                {{ sku.tags_string }}
            </div>

            <div class="text-copy-sm font-bold">
                {{ sku.product_title }}
            </div>

            <div class="text-copy-xs capitalize leading-tight">
                — {{ sku.color_title }}
            </div>

            <div class="flex gap-[15px] mt-[8px] items-center">
                <div class="min-w-[50px]">
                    <SelectField
                        formBg="white"
                        v-model="localQuantity"
                        :options="quantityOptions"
                    />
                </div>

                <div>
                    {{ money.formatted(quantity * sku.price) }}&nbsp;{{ $shared.currencySign }}
                </div>
            </div>
        </div>

        <button
            class="
                block text-headline-base md:text-headline-lg leading-none font-extralight
                absolute top-[7px] right-[7px] h-[12px] fill-black
            "
            @click="cartStore.removeItem(sku.id)"
        >
            <Close />
        </button>

        <div
            v-if="sku.is_preorder"
            class="
                bg-error text-white absolute top-0 left-0 text-copy-xs uppercase px-[5px] leading-none py-[2px]
                font-semibold
            "
        >
            {{ $trans.shop.preorder }}
        </div>
    </div>
</template>
