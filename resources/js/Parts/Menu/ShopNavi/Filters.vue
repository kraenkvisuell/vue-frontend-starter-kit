<script setup>
import { useShopStore } from '../../../Stores/ShopStore'

import Cross from '../Filters/Cross.vue'
import Filter from '../Shop/Filter.vue'
import Icon from '../Filters/Icon.vue'
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

const shopStore = useShopStore()

let order = [
    { title: 'Preis aufsteigen' },
    { title: 'Preis absteigen' },
    { title: 'Größe aufsteigen' },
    { title: 'Größe absteige' },
]

</script>

<template>
    <div class="pl-[10px]">
        <button
            @click="shopStore.toggleFilters"
            class="ml-[-5px] flex text-gray-800 text-copy-sm tracking-normal items-center"
        >
            <div class="w-icon h-icon fill-gray-800 flex mr-[0.3rem] justify-center">
                <Icon v-if="!shopStore.filtersAreOpen" />
                <Cross v-else />
            </div>

            {{ $trans.shop.filters_and_sorting }}
        </button>


        <div v-show="shopStore.filtersAreOpen" class="pb-[20px] pt-[10px] grid gap-[20px] grid-cols-2 sm:grid-cols-1">
            <div class="grid gap-[2px]">
                <Filter
                    :options="shopStore.selectableColorGroups"
                    filterName="colorGroup"
                    :emptyLabel="$trans.shop.all_colors"
                />

                <Filter
                    :options="shopStore.selectableSizes"
                    filterName="size"
                    :emptyLabel="$trans.shop.all_sizes"
                />
            </div>


            <div>
                <div class="text-gray-800 text-copy-xs pt-[6px] tracking-normal">
                    {{ $trans.shop.sort_by }}
                </div>

                <Filter
                    :options="shopStore.sortBys"
                    filterName="sortBy"
                />
            </div>
        </div>
    </div>
</template>
