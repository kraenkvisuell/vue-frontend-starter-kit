<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useLinks } from '../Composables/useLinks.js'

const { getLink, linkType, ensureUrl } = useLinks()

const props = defineProps({
    item: Object,
})

const tag = computed(() => {
    if (linkType(props.item) === 'external') {
        return 'a'
    } else if (getLink(props.item)) {
        return Link
    }

    return 'div'
})

const href = computed(() => {
    return getLink(props.item) ? getLink(props.item) : null
})
</script>


<template>
    <component :is="tag" :href="href" :target="linkType(props.item) === 'external' ? '_blank' : null">
        <slot />
    </component>
</template>
