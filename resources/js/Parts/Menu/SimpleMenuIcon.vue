<script setup>
import Bar from '../../Shared/Bar.vue'

const props = defineProps({
    clickMethod: Function
})
</script>

<template>
    <button @click="clickMethod">
        <div
            class="
                text-black hover:text-gray-800 fill-black hover:fill-gray-800
                relative cursor-pointer flex items-center justify-center
                h-icon w-[21px]
            "
        >
            <div class=" absolute left-0 top-0 h-full flex -mt-[6px]">
                <Bar/>
            </div>

            <div class="absolute left-0 top-0 h-full flex">
                <Bar/>
            </div>

            <div class=" absolute left-0 top-0 h-full flex mt-[6px]">
                <Bar/>
            </div>
        </div>
    </button>
</template>
