<script setup>
import { useRatio } from '../Composables/useRatio.js'
import CaptionAndCredits from '../Shared/CaptionAndCredits.vue'

const { ratioClasses } = useRatio()

const props = defineProps({
    block: Object,
})
</script>

<template>
    <div class="mx-auto max-w-screen-lg">
        <div class="embed-code" :class="[ratioClasses(block.ratio.value)]" v-html="block.embed_code.value" />

        <CaptionAndCredits
            :caption="block.caption ? block.caption.text : ''"
            :credits="block.credits ? block.credits.text : ''"
        />
    </div>
</template>
