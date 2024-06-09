<script setup>
import ContentBlocks from '../Blocks/ContentBlocks.vue'
import HeadMeta from '../Parts/HeadMeta.vue'
import Hero from '../Parts/Hero.vue'
import PageContainer from './Shared/PageContainer.vue'
import PageMain from '../Shared/PageMain.vue'
import TitleWithoutHero from '../Parts/Hero/TitleWithoutHero.vue'
import _ from 'lodash'
import { computed } from 'vue'

const props = defineProps({
    entry: Object,
})

const blocks = computed(() => props.entry.blocks && props.entry.blocks.length ? props.entry.blocks : [])

const seoTitle = computed(() => {
    if (props.entry.seo_title && props.entry.seo_title.text) {
        return props.entry.seo_title.text
    }

    return props.entry.title
})

const ogTitle = computed(() => {
    if (props.entry.og_title && props.entry.og_title.text) {
        return props.entry.og_title.text
    }

    return seoTitle.value
})

const seoDescription = computed(() => {
    if (props.entry.seo_description && props.entry.seo_description.text) {
        return props.entry.seo_description.text
    }

    return ''
})

const ogDescription = computed(() => {
    if (props.entry.og_description && props.entry.og_description.text) {
        return props.entry.og_description.text
    }

    return seoDescription.value
})

const ogImage = computed(() => {
    if (props.entry.og_image && props.entry.og_image.is_image) {
        return props.entry.og_image
    }

    return null
})

const twitterCardImage = computed(() => {
    if (props.entry.twitter_card_image && props.entry.twitter_card_image.is_image) {
        return props.entry.twitter_card_image
    }

    return ogImage.value
})
</script>

<template>
    <HeadMeta
        :seoTitle="seoTitle"
        :ogTitle="ogTitle"
        :seoDescription="seoDescription"
        :ogDescription="ogDescription"
        :ogImage="ogImage"
        :twitterCardImage="twitterCardImage"
    />

    <Hero v-if="entry.has_hero" :entry="entry" />

    <TitleWithoutHero v-else-if="entry.show_title" :entry="entry" />

    <div v-else class="h-[60px]" />

    <div id="maincontent" class="scroll-mt-[120px]">
        <PageContainer>
            <PageMain>
                <ContentBlocks :blocks="blocks" />
            </PageMain>
        </PageContainer>
    </div>
</template>
