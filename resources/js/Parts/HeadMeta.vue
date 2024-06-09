<script setup>
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useMedia } from '../Composables/useMedia.js'

const { imageLink } = useMedia()

const props = defineProps({
    seoTitle: {
        type: String,
        default: '',
    },
    ogTitle: {
        type: String,
        default: '',
    },
    seoDescription: {
        type: String,
        default: '',
    },
    ogDescription: {
        type: String,
        default: '',
    },
    ogImage: {
        type: Object,
        default: null,
    },
    twitterCardImage: {
        type: Object,
        default: null,
    },
    ogImageRatio: {
        type: String,
        default: 'default',
    },
})

const computedSeoTitle = computed(() => {
    if (props.seoTitle) {
        return props.seoTitle
    }

    if ($shared.globals.website.seo_title && $shared.globals.website.seo_title.text) {
        return $shared.globals.website.seo_title.text
    }

    return $shared.websiteName
})

const computedOgTitle = computed(() => {
    if (props.ogTitle) {
        return props.ogTitle
    }

    return computedSeoTitle.value
})

const seoTitleWithSuffix = computed(() => {
    let title = computedSeoTitle.value

    if (title.indexOf($shared.websiteName) < 0) {
        title = title + ' / ' + $shared.websiteName
    }

    return title
})

const ogTitleWithSuffix = computed(() => {
    let title = computedOgTitle.value

    if (title.indexOf($shared.websiteName) < 0) {
        title = title + ' / ' + $shared.websiteName
    }

    return title
})

const computedSeoDescription = computed(() => {
    if (props.seoDescription) {
        return props.seoDescription
    }

    if ($shared.globals.website.seo_description && $shared.globals.website.seo_description.text) {
        return $shared.globals.website.seo_description.text
    }

    return ''
})

const computedOgDescription = computed(() => {
    if (props.ogDescription) {
        return props.ogDescription
    }

    return computedSeoDescription.value
})

const computedOgImage = computed(() => {
    let fit = [1200, 630]

    if (props.ogImageRatio === 'square') {
        fit = [1200, 1200]
    }

    const params = { crop: true, fit: fit }

    if (props.ogImage && props.ogImage.is_image) {
        return imageLink(props.ogImage, params)
    }

    if ($shared.globals.website.og_image && $shared.globals.website.og_image.is_image) {
        return imageLink($shared.globals.website.og_image, params)
    }

    return ''
})

const computedTwitterCardImage = computed(() => {
    let fit = [1024, 512]

    const params = { crop: true, fit: fit }

    if (props.twitterCardImage && props.twitterCardImage.is_image) {
        return imageLink(props.twitterCardImage, params)
    }

    if (props.ogImage && props.ogImage.is_image) {
        return imageLink(props.ogImage, params)
    }

    return ''
})
</script>

<template>
    <Head>
        <title>{{ seoTitleWithSuffix }}</title>
        <meta name="description" :content="computedSeoDescription" />
        <meta property="og:description" :content="computedOgDescription" />
        <meta property="og:title" :content="ogTitleWithSuffix" />

        <meta v-if="computedOgImage" property="og:image" :content="computedOgImage" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@zweibags">
        <meta name="twitter:title" :content="ogTitleWithSuffix">
        <meta name="twitter:description" :content="computedOgDescription">
        <meta v-if="computedTwitterCardImage" name="twitter:image" :content="computedTwitterCardImage">
    </Head>
</template>
