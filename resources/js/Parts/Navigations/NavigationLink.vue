<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useMenuStore } from '../../Stores/MenuStore'

const menuStore = useMenuStore()

const props = defineProps({
    page: Object,
})

const title = computed(() => {
    if (props.page.localized_nav_title && props.page.localized_nav_title.text) {
        return props.page.localized_nav_title.text
    }

    if (props.page.localized_title && props.page.localized_title.text) {
        return props.page.localized_title.text
    }

    return props.page.title
})

const url = computed(() => {
    if (props.page.is_external) {
        return props.page.url
    }

    if (props.page.slug) {
        return route('pages.show', [$shared.locale, props.page.slug])
    }

    return props.page.url.replace('/de/', '/' + $shared.locale + '/')
})
</script>

<template>
    <component
        :is="page.is_external ? 'a' : Link"
        @click="menuStore.close"
        :href="url"
        :target="page.is_external ? '_blank' : null"
    >
        {{ title }}
    </component>
</template>
