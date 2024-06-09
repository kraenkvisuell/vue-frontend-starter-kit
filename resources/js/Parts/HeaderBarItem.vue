<script setup>
import { computed } from 'vue'
import { useLinks } from '../Composables/useLinks.js'
import LinkTag from '../Shared/LinkTag.vue'

const { getLink } = useLinks()

const props = defineProps({
    item: Object,
})

const hasLink = computed(() => {
    return props.item.has_link && getLink(props.item.link)
})
</script>

<template>
    <component :is="hasLink ? LinkTag : 'div'" :item="item.link" class="block">
        {{ item.text ? item.text.text : '' }}
    </component>
</template>
