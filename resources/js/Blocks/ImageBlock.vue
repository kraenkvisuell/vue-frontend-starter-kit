<script setup>
import BlockYMargin from '../Shared/BlockYMargin.vue'
import CaptionAndCredits from '../Shared/CaptionAndCredits.vue'
import Medium from '../Shared/Medium.vue'
import { useRatio } from '../Composables/useRatio.js'

const { ratioClasses } = useRatio()

const props = defineProps({
    block: Object,
})
</script>

<template>
    <BlockYMargin>
        <div class="w-full mx-auto max-w-screen-lg rounded">
            <div
                :class="[
                    'rounded-t overflow-hidden',
                    block.force_ratio ? ratioClasses(block.ratio.value) : '',
                ]"
            >
                <Medium
                    v-if="block.image_file"
                    :file="block.image_file"
                    :mediumFit="block.medium_fit ? block.medium_fit.value : 'center'"
                    :forceRatio="block.force_ratio"
                    :ratio="block.ratio.value"
                />
            </div>

            <CaptionAndCredits
                :caption="block.caption ? block.caption.text : ''"
                :credits="block.credits ? block.credits.text : ''"
            />
        </div>
    </BlockYMargin>
</template>
