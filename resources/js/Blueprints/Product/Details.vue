<script setup>
import DetailsInfo from './Details/Info.vue'
import DetailsTable from './Details/Table.vue'
import ShowMoreArrow from '../../Svg/ShowMoreArrow.vue'
import { useProductStore } from '../../Stores/ProductStore.js'
import { useStrings } from '../../Composables/useStrings.js'

const { nl2br } = useStrings()

const productStore = useProductStore()

let showDetails = true

const toggleDetails = () => {
    showDetails = !showDetails
}
</script>

<template>
    <div class="w-full flex justify-between">
        <button
            class="
                flex items-center text-copy-sm font-bold tracking-normal
                hover:text-gray-800 fill-black hover:fill-gray-800
            "
        >
            {{ $trans.products.product_details }}

            <div
                class="h-[6px] ml-[6px] mt-[2px] hidden"
                :class="{
                    'rotate-180': showDetails,
                }"
            >
                <ShowMoreArrow />
            </div>
        </button>
    </div>

    <div class="w-full border-b border-gray-600 pt-[20px] sm:pt-[25px]"></div>

    <template v-if="showDetails">
        <DetailsTable
            v-if="productStore.product.dimensions"
            :headline="$trans.products.dimensions"
            :text="productStore.product.dimensions"
        />


        <DetailsTable
            v-if="productStore.product.volume"
            :headline="$trans.products.volume"
            :text="productStore.product.volume"
        />


        <DetailsTable
            v-if="productStore.product.weight"
            :headline="$trans.products.weight"
            :text="productStore.product.weight+' g'"
        />

        <DetailsTable
            v-if="productStore.product.material_details"
            :headline="$trans.products.material"
            :text="nl2br(productStore.product.material_details)"
        />

        <DetailsTable
            v-if="productStore.product.features"
            :headline="$trans.products.features"
            :text="nl2br(productStore.product.features)"
        />

        <DetailsTable
            v-if="productStore.product.laptop_dimensions"
            :headline="$trans.products.laptop_dimensions"
            :text="productStore.product.laptop_dimensions+' cm'"
        />

        <DetailsInfo
            v-if="productStore.product.contains_magnets"
            :headline="$trans.products.attention_magnets"
            :text="nl2br($trans.products.magnets_warning)"
        />


    </template>
</template>
