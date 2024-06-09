<script setup>
import Info from '../../../Svg/Info.vue'

const props = defineProps({
    headline: {type: String, default: ''},
    text: {type: String, default: ''},
})
</script>

<template>
    <div
        class=" text-gray-800 text-copy-sm border-b border-gray-600"
        :class="{
            'pt-[0.55rem] pb-[0.65rem]': headline,
            'pt-[0.65rem] pb-[0.7rem]': !headline,
        }"
    >

        <div v-if="headline" class="text-copy-xs font-medium tracking-wide uppercase mt-[0.1rem] mb-[0.3rem] flex">
            <div class="w-[1.1rem] h-[1.1rem] fill-gray-800 mr-[0.3rem]">
                <Info/>
            </div>

            {{ headline }}
        </div>

        <div v-html="text"/>
    </div>
</template>
