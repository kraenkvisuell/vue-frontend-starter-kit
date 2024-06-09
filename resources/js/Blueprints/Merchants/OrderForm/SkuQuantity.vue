<script setup>
import {computed} from 'vue'
import TextField from '../../../Forms/TextField.vue'
import {useSkuQuantityStore} from '../../../Stores/Merchants/SkuQuantityStore.js'

const props = defineProps({
    sku: Object,
})

const store = useSkuQuantityStore(props.sku)

const availabilityString = computed(() => {
    if (props.sku.availability === 'sold_out') {
        return $trans.shop.sold_out
    }
    if (props.sku.is_preorder) {
        return props.sku.preorder_availability
    }
    if (props.sku.availability === 'month_name') {
        return props.sku.preorder_availability
    }
    return $trans.shop.in_stock
})

const availabilityColor = computed(() => {
    if (props.sku.availability === 'sold_out') {
        return 'warning'
    }
    if (props.sku.is_preorder) {
        return 'warning'
    }
    if (props.sku.availability === 'month_name') {
        return 'warning'
    }
    return 'success'
})

// console.log(props.sku)
</script>

<template>


    <div class="w-[120px] h-full pt-[9px] grid gap-[3px]">
        <div class="flex items-center gap-[10px]">
            <button
                @click="store.decrement()"
                class="text-copy-xl font-bold"
                :class="{'opacity-30' : store.quantity < 1}"
                :disabled="store.quantity < 1"
            >
                -
            </button>

            <div>
                <TextField
                    v-model="store.quantity"
                    formBg="white"
                    align="center"
                />
            </div>

            <button
                @click="store.increment()"
                class="text-copy-xl font-bold"
            >
                +
            </button>
        </div>

        <div
            class="text-center text-copy-xs"
            :class="{
                'text-error': availabilityColor === 'warning',
                'text-highlight': availabilityColor === 'success',
            }"
        >
            {{ availabilityString }}
        </div>
    </div>


</template>
