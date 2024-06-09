<script setup>
import {Link} from '@inertiajs/vue3'
import {useMenuStore} from '../../../Stores/MenuStore'

const menuStore = useMenuStore()
import ShopCategoryLink from '../../../Shared/ShopCategoryLink.vue'
import ActiveArrow from './ActiveArrow.vue'

const props = defineProps({
    text: String,
    url: String,
    isShop: {type: Boolean, default: false},
    isActive: {type: Boolean, default: false},
})

</script>

<template>
    <component
        :is="isShop ? ShopCategoryLink : Link"
        :href="url"
        class="
            block text-copy-sm rounded cursor-pointer py-[3px] my-[2px]
            font-bold tracking-normal hover:text-gray-800 pl-[10px]
        "
        :class="{
            'bg-white': isActive,
        }"
    >
        <div>
            {{ text }}
            <ActiveArrow v-show="isActive"/>
        </div>
    </component>
</template>
