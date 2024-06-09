<script setup>
import Bar from '../../../Shared/Bar.vue'
</script>

<template>
    <div
        class="
            text-gray-800 hover:text-black fill-gray-800 hover:fill-black
            relative cursor-pointer flex items-center justify-center
            h-icon w-[21px]
        "
    >
        <div class="absolute left-0 top-0 h-full flex transition-all duration-300 rotate-45">
            <Bar/>
        </div>

        <div class="absolute left-0 top-0 h-full flex transition-all duration-300 -rotate-45">
            <Bar/>
        </div>
    </div>
</template>
