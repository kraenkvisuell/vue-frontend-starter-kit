<script setup>
import ShowMoreArrow from '../../../Svg/ShowMoreArrow.vue'
import ActiveArrow from './ActiveArrow.vue'

const props = defineProps({
    isActive: { type: Boolean, default: false },
    activeTag: { type: String, default: null },
})

const tagIsActive = (tag) => props.activeTag === tag
</script>

<template>
    <div class="block text-copy-sm rounded cursor-pointer w-full text-start font-bold tracking-normal fill-black">
        <div
            class="flex py-[3px] pl-[10px]"
            :class="{
                'bg-white': isActive && tagIsActive(''),
            }"
        >

            <div>
                <slot name="label" />
            </div>

            <span
                class="flex items-center group"
                :class="{
                    'hover:text-gray-200': isActive,
                    'hover:text-gray-800': !isActive,
                }"
            >
                <span
                    class="block h-[6px] ml-[6px] mt-[2px]"
                    v-show="!isActive"
                >
                    <ShowMoreArrow />
                </span>
            </span>

            <ActiveArrow v-show="isActive && !activeTag" />
        </div>

        <div
            v-show="isActive"
            class="pb-[6px] pt-[1px] font-normal hover:text-gray-800 text-gray-800"
        >
            <slot name="options" />
        </div>
    </div>
</template>

