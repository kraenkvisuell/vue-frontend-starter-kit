<script setup>
import Navigation from './Navigation.vue'
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
    <div class="w-full flex flex-col xs:flex-row items-start md:pb-0 gap-[25px] lg:gap-[50px]">
        <Navigation v-for="nav in navs" :title="nav.title" :pages="nav.pages" />
    </div>
</template>


