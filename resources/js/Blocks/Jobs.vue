<script setup>
import BlockYMargin from '../Shared/BlockYMargin.vue'
import Job from './Job.vue'
import { usePage } from '@inertiajs/vue3'

let jobs = usePage().props.jobs

const props = defineProps({
    block: Object,
})
</script>

<template>
    <BlockYMargin>
        <div class="max-w-screen-md mx-auto grid gap-[22px]">
            <div
                v-if="block.intro && block.intro.text"
                class="editor px-[20px] sm:px-[35px]"
                v-html="block.intro.text"
            />

            <div class="grid gap-[30px]">
                <Job v-for="job in jobs" :job="job" />
            </div>
        </div>
    </BlockYMargin>
</template>

