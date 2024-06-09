<script setup>
import AccountDropdown from './AccountDropdown.vue'
import Language from './Language.vue'
import Navigations from '../Navigations.vue'
import SearchField from './SearchField.vue'
import SearchIcon from './SearchIcon.vue'
import ShopNaviForPages from './ShopNaviForPages.vue'
import { computed } from 'vue'
import { useMedia } from '../../Composables/useMedia.js'

const { imageLink } = useMedia()

const bgImage = computed(() => {
    if ($shared.globals.website.navi_bg && $shared.globals.website.navi_bg.path) {
        return imageLink($shared.globals.website.navi_bg, { fit: [1200, 1200] })
    }

    return ''
})
</script>

<template>
    <div>
        <div class="grid md:grid-cols-2 items-start">
            <div class="bg-white">
                <ShopNaviForPages class="z-10" />

                <div v-if="bgImage" class="@container absolute top-0 left-0 w-full h-full">
                    <img
                        :src="bgImage"
                        class="w-full h-full object-cover @md:object-contain object-right"
                        loading="lazy"
                    />
                </div>
            </div>

            <div class="px-[30px] pt-[17px] pb-[30px] grid gap-[15px]">
                <div class="flex w-full justify-between xs:grid xs:grid-cols-2 gap-[15px] items-center z-10">
                    <div class="w-full xs:w-auto ml-[-12px]">
                        <SearchField />
                    </div>

                    <div class="flex gap-[20px] items-center justify-between md:mr-[34px]">
                        <div class="mt-[2px]">
                            <SearchIcon />
                        </div>

                        <div class="flex items-center gap-[26px] mr-[-12px] md:mr-0">
                            <Language />

                            <div class="mt-[3px]">
                                <AccountDropdown />
                            </div>
                        </div>
                    </div>
                </div>

                <Navigations />
            </div>
        </div>
    </div>
</template>
