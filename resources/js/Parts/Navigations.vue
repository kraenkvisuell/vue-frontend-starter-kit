<script setup>
import Navigation from './Navigations/Navigation.vue'
import _ from 'lodash'

let navs = []

_.each(['zwei', 'service'], (handle) => {
    navs.push({
        title: $trans.shop[handle],
        pages: $shared.nav[handle],
    })
})
</script>

<template>
    <div class="w-full grid xs:grid-cols-2 md:pb-0 gap-[30px] xs:gap-[15px]">
        <div v-for="nav in navs">
            <Navigation :title="nav.title" :pages="nav.pages" />
        </div>
    </div>
</template>


