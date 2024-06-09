<script setup>
import {Head} from '@inertiajs/vue3'
import ContentBlocks from '../Blocks/ContentBlocks.vue'
import Hero from '../Parts/Hero.vue'
import PageContainer from './Shared/PageContainer.vue'
import PageMain from '../Shared/PageMain.vue'
import {computed} from 'vue'

const props = defineProps({
    entry: Object,
})

let blocks = computed(() => props.entry.blocks && props.entry.blocks.length ? props.entry.blocks : [])
</script>

<template>
    <Head :title="$shared.websiteName+' | '+entry.title"/>

    <Hero v-if="entry.hero_type" :entry="entry"/>

    <div id="maincontent" class="scroll-mt-[120px]">
        <PageContainer>
            <PageMain>
                <ContentBlocks :blocks="blocks"/>
            </PageMain>
        </PageContainer>
    </div>
</template>
