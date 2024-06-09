<script setup>
import PageContainer from './Shared/PageContainer.vue'
import PageMain from '../Shared/PageMain.vue'
import {Head, usePage} from '@inertiajs/vue3'
import BlockYMargin from '../Shared/BlockYMargin.vue'
import {computed} from 'vue'
import Hero from '../Parts/Hero.vue'

//console.log($shared.globals)

const successText = computed(() => {
    if (usePage().props.paymentKind === 'stripe') {
        return $shared.globals.shop.stripe_success_page.text
    }

    return $shared.globals.shop.prepayment_success_page.text
})

const entryForHero = computed(() => {
    let entry = $shared.globals.shop

    entry.title = 'Ihre Bestellung ist eingegangen'
    entry.show_title = true
    entry.hero_size.value = 'md'
    return entry
})
</script>

<template>
    <Head :title="$shared.websiteName+' | Vielen Dank für Ihre Bestellung'"/>

    <Hero :entry="entryForHero"/>

    <PageContainer>
        <PageMain>
            <BlockYMargin>
                <div class="editor" v-html="successText"/>
            </BlockYMargin>
        </PageMain>
    </PageContainer>
</template>
