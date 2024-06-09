<script setup>
import lottie from 'lottie-web'
import { onMounted } from 'vue'

onMounted(() => {
    console.log('foo')
    lottie.loadAnimation({
        container: document.getElementById('animatedLogo'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/json/ZweiLogo2024_6.json',
    })
})
</script>
<template>
    <div class="mt-[-19px]">
        <div id="animatedLogo" class="w-[112px] h-[63px]"></div>
    </div>
</template>
