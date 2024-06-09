<script setup>
import ContentBlocks from '../Blocks/ContentBlocks.vue'
import HeroPage from '../Parts/HeroPage.vue'
import IntroText from './Shared/IntroText.vue'
import Jobs from '../Blocks/Jobs.vue'
import PageContainer from './Shared/PageContainer.vue'
import Section from '../Shared/Section.vue'
import ShopNaviContainer from './Shared/ShopNaviContainer.vue'
import ShopNaviForPages from '../Parts/Menu/ShopNaviForPages.vue'
import {Head} from '@inertiajs/vue3'

const props = defineProps({
    entry: {
        type: Object,
        default: {},
    }
})
</script>

<template>
    <Head :title="$shared.websiteName+' | '+entry.title"/>

    <HeroPage :title="entry.title"/>

    <PageContainer>
        <div>
            <div class="pt-[40px] sm:pt-[60px]">
                <Section>
                    <IntroText v-if="entry.intro_text && entry.intro_text.text" :text="entry.intro_text.text"/>

                    <ContentBlocks :entry="entry"/>
                    <Jobs :entry="entry"/>
                </Section>
            </div>
        </div>
    </PageContainer>
</template>
