<script setup>
import Bar from './Bar.vue'
</script>

<template>
    <div class="w-[32px] h-[32px] mr-[-8px] mt-[-4px]">
        <div class=" absolute left-0 top-0 h-full flex transition-all duration-300 rotate-45 origin-center">
            <Bar/>
        </div>

        <div class=" absolute left-0 top-0 h-full flex transition-all duration-300 -rotate-45 origin-center">
            <Bar/>
        </div>
    </div>
</template>
