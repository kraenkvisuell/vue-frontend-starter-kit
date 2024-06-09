<script setup>
import Arrow from '../Svg/Arrow.vue'

const props = defineProps({
    isFirst: {type: Boolean, default: false}
})
</script>

<template>
    <div class="flex items-center">
        <div v-if="!isFirst" class="h-[20px] mt-[1px] -rotate-90">
            <Arrow/>
        </div>

        <div>
            <slot/>
        </div>
    </div>
</template>
