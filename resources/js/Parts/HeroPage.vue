<script setup>
import HeroMedium from '../Shared/HeroMedium.vue'
import {computed} from 'vue'

const props = defineProps({
    title: String,
    hero: {type: Object, default: null},
})

let localHero = computed(() => props.hero ? props.hero : $shared.globals.shop.hero_image)
</script>

<template>
    <div
        v-if="localHero"
        class="
            z-40 min-h-[50px] sm:min-h-[56px] mt-[50px] sm:mt-[56px] bg-black
            text-center text-white uppercase font-extrabold text-headline-lg tracking-wider
            py-[0.8rem] px-[20px] leading-[2.1rem]
        "
    >
        <div class="absolute inset-0">
            <HeroMedium
                :file="localHero.medium_file"
                :type="localHero.medium_type.value"
                :alt="localHero.medium_alt.text"
            />
        </div>

        <div class="h-full w-full absolute top-0 left-0 bg-darkest opacity-30"/>

        <div class="h-[80px] w-full absolute bottom-0 left-0 bg-gradient-to-t from-darkest opacity-70"/>

        <h1 class="z-10">
            {{ title }}
        </h1>
    </div>
</template>
