<script setup>
import ForwardArrow from './Swiper/ForwardArrow.vue'
import BackArrow from './Swiper/BackArrow.vue'


</script>

<template>
    <div class="">
        <div>
            <slot/>
        </div>
        <ForwardArrow/>
        <BackArrow/>
    </div>
</template>
