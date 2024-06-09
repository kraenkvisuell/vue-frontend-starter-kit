<script setup>
import Arrow from './Language/Arrow.vue'
import Selection from './Language/Selection.vue'
import _ from 'lodash'
import nprogress from 'nprogress'
import { onClickOutside } from '@vueuse/core'
import { ref } from 'vue'

const isOpen = ref(false)
const languageDropdown = ref(null)

const toggleLanguage = () => isOpen.value = !isOpen.value

onClickOutside(languageDropdown, event => isOpen.value = false)

const languageLink = (language) => {
    const currentPath = location.pathname
    let newPath = '/'
    let pathArray = _.filter(currentPath.split('/'))

    if (currentPath === '/') {
        return '/' + language + '/home'
    }

    if (pathArray.length === 2) {
        if (pathArray[1] !== 'home' || language !== 'de') {
            return '/' + language + '/' + pathArray[1]
        }
    }

    if (pathArray.length === 3) {
        return '/' + language + '/' + pathArray[1] + '/' + pathArray[2]
    }

    return newPath
}

// console.log($shared.languages)
</script>

<template>
    <button
        @click="toggleLanguage"
        class="block relative cursor-pointer h-[20px] w-[45px] font-bold text-copy-2xs"
        ref="languageDropdown"
    >
        <div class="
            absolute top-0 left-0 h-full w-full flex items-center justify-center gap-[5px]
            border-black border-[1.5px] rounded-full
        ">
            <div class="h-[4px] flex-shrink-0 fill-gray-800">
                <Arrow />
            </div>

            <div class="text-black tracking-wide uppercase">
                {{ $shared.locale }}
            </div>
        </div>


        <div
            v-show="isOpen"
            class="
                absolute top-0 left-0 bg-white px-[15px] -ml-[15px] py-[9px] -my-[8px] rounded-[16px]
                grid gap-[5px]
            "
        >
            <template v-for="language in $shared.languages">
                <a @click="nprogress.start()" :href="languageLink(language.key)">
                    <Selection>{{ language.key }}</Selection>
                </a>
            </template>
        </div>
    </button>
</template>
