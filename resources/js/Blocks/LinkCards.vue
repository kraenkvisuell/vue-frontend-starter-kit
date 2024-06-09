<script setup>
import LinkCard from './LinkCard.vue'
import BlockYMargin from '../Shared/BlockYMargin.vue'

const props = defineProps({
    block: Object,
})
</script>

<template>
    <BlockYMargin>
        <div class="
            mx-auto max-w-screen-2xl grid grid-cols-2 lg:grid-cols-4 gap-[4px]
        ">
            <LinkCard v-for="card in block.cards" :card="card" />
        </div>
    </BlockYMargin>
</template>
