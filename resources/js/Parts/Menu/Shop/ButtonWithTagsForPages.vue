<script setup>
import ShowMoreArrow from '../../../Svg/ShowMoreArrow.vue'
import {Link} from '@inertiajs/vue3'
import {useMenuStore} from '../../../Stores/MenuStore'
import {ref} from 'vue'

const menuStore = useMenuStore()

const props = defineProps({
    category: Object,
})

let showTags = ref(false)
const toggleTags = () => {
    showTags.value = !showTags.value
}
</script>

<template>
    <button
        @click="toggleTags"
        class="
            text-copy-sm rounded cursor-pointer px-[1rem] py-[0.6rem] mb-[2px] w-full text-start
            bg-white font-bold tracking-normal fill-black
        "
    >
        <div class="flex items-center group">
            {{ category.title }}

            <div
                class="h-[0.35rem] ml-[0.35rem] mt-[0.1rem] group-hover:fill-gray-800"
                :class="{
                    'rotate-180': showTags,
                }"
            >
                <ShowMoreArrow/>
            </div>
        </div>


        <div v-if="showTags" class="pl-[0.6rem] pb-[0.6rem] font-normal hover:text-gray-800 text-gray-800">
            <Link
                v-for="tag in category.tags"
                @click="menuStore.close"
                :href="$route('shop.tag', [$shared.locale, category.slug, tag.slug])"
                class="block mt-[0.6rem] hover:text-black"
            >
                {{ tag.title }}
            </Link>
        </div>
    </button>
</template>
