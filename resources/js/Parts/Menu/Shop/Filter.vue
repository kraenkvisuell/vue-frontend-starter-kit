<script setup>
import ShowMoreArrow from '../../../Svg/ShowMoreArrow.vue'
import {computed, ref} from 'vue'
import {useShopStore} from '../../../Stores/ShopStore.js'
import Close from '../../../Svg/Close.vue'

const shopStore = useShopStore()

const props = defineProps({
    options: Array,
    emptyLabel: {type: String, default: ''},
    selectedLabel: String,
    filterName: String,

})

const label = computed(() => {
    return shopStore.selectedFilters[props.filterName]
        ? shopStore.selectedFilters[props.filterName].label
        : props.emptyLabel
})

const selectedColor = computed(() => {
    return shopStore.selectedFilters[props.filterName]
        ? shopStore.selectedFilters[props.filterName].color
        : null
})

const isOpen = computed(() => shopStore.filterIsOpen[props.filterName])
</script>

<template>
    <div class="w-full">
        <button
            class="
                w-full flex items-center group
                text-copy-sm cursor-pointer py-[3px]
                font-semibold tracking-wide hover:text-gray-800
            "
            :class="{
                'pl-[10px] bg-white': emptyLabel && shopStore.selectedFilters[props.filterName],
            }"
        >
            <span
                class="flex w-full items-center"
                @click="shopStore.toggleFilter(filterName)"
            >

                <span class="block capitalize">{{ label }}</span>

                <span
                    v-show="!shopStore.selectedFilters[props.filterName] || !emptyLabel"
                    class="block h-[0.35rem] ml-[0.35rem] mt-[0.1rem] fill-white group-hover:fill-gray-200"
                    :class="{
                        'rotate-180': isOpen,
                    }"
                >
                    <ShowMoreArrow/>
                </span>
            </span>

            <span
                v-if="emptyLabel"
                v-show="shopStore.selectedFilters[props.filterName]"
                class="flex h-full w-[32px] absolute top-0 right-0 items-center justify-center"
                @click="shopStore.clearFilter(filterName)"
            >
                <span class="block h-[10px] fill-white">
                    <Close/>
                </span>
            </span>
        </button>

        <div
            v-if="isOpen"
            class="
                tracking-wide text-copy-sm
                cursor-pointer overflow-hidden
            "
        >
            <button
                v-if="emptyLabel"
                v-show="shopStore.selectedFilters[props.filterName]"
                class="sm:pl-[18px] py-[4px] w-full text-left hover:text-gray-800 flex items-center"
                @click="shopStore.clearFilter(filterName)"
            >
                <span class="capitalize">{{ emptyLabel }}</span>
            </button>


            <button
                v-for="option in options"
                class="sm:pl-[10px] pb-[2px] pt-[2px] w-full text-left hover:text-gray-800 flex items-center"
                @click="shopStore.changeFilter(filterName, option)"
            >
                <span
                    v-if="option.color"
                    class="hidden rounded-full h-[0.8rem] w-[0.8rem] -ml-[0.1rem] mr-[0.3rem]"
                    :style="{backgroundColor: option.color}"
                />

                <span class="capitalize">{{ option.label }}</span>
            </button>
        </div>
    </div>
</template>
