<script setup>
import { useObjects } from '../Composables/useObjects.js'
import JobForm from '../Shared/JobForm.vue'
import ArrowBack from './Shared/ArrowBack.vue'
import ContentBlocks from '../Blocks/ContentBlocks.vue'
import Hero from '../Parts/Hero.vue'
import PageContainer from './Shared/PageContainer.vue'
import PageMain from '../Shared/PageMain.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const { flattenProxy } = useObjects()

const props = defineProps({
    entry: Object,
})

const entryForHero = computed(() => {
    let newEntry = flattenProxy(props.entry)
    newEntry.title = 'Job'
    return newEntry
})
</script>

<template>
    <Head :title="$shared.websiteName+' | '+entry.title" />

    <Hero
        v-if="entry.has_hero"
        :entry="entryForHero"
        :forceShowTitle="true"
    />

    <div v-else class="w-full h-[90px]">

    </div>

    <PageContainer>
        <PageMain>
            <div class="grid gap-[40px] sm:gap-[60px]">
                <a href="javascript:history.back()" class="flex flex-wrap pt-[30px]">
                    <ArrowBack url="javascript:history.back()" />
                </a>

                <h1 class="text-center px-[40px]">
                    <div
                        class="
                            uppercase font-black text-headline-lg tracking-wider leading-[2.1rem]
                            hyphens-auto md:hyphens-none
                        "
                    >
                        {{ entry.title }}
                    </div>

                    <div class="text-gray-800 pt-[50x]">
                        {{ entry.subtitle.text ? entry.subtitle.text : '(' + $trans.shop.mfd + ')' }}
                    </div>
                </h1>

                <ContentBlocks :blocks="entry.blocks ? entry.blocks : []" />

                <div class="flex justify-center">
                    <div class="w-full max-w-screen-lg">
                        <JobForm :job="entry" />
                    </div>
                </div>
            </div>
        </PageMain>
    </PageContainer>
</template>
