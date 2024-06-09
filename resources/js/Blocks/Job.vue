<script setup>
import { Link } from '@inertiajs/vue3'
import LongArrow from '../Svg/LongArrow.vue'

const props = defineProps({
    job: Object,
})

//console.log(props.job)

let bgColor = '#292C28'
</script>

<template>
    <Link
        :href="$route('jobs.show', [$shared.locale, job.slug])"
        class="w-full rounded text-white tracking-wide px-[25px] pt-[20px] pb-[24px] sm:px-[35px] flex items-center justify-between"
        :style="{backgroundColor: bgColor}"
    >
        <div>
            <div class="font-semibold text-copy-lg sm:text-headline-base">
                {{ job.title }}
            </div>

            <div class="font-light text-copy-sm">
                {{ job.subtitle.text ? job.subtitle.text : '(' + $trans.shop.mfd + ')' }}
            </div>
        </div>

        <div class="h-[10px] sm:h-[15px] fill-white ml-[20px]">
            <LongArrow />
        </div>
    </Link>
</template>
