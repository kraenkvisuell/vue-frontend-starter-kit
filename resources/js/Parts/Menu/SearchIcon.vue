<script setup>
import { storeToRefs } from 'pinia'
import MagnifyingGlass from './Search/MagnifyingGlass.vue'
import { useSearchStore } from '../../Stores/SearchStore'

const searchStore = useSearchStore()
const { needle } = storeToRefs(searchStore)

const enterMethod = () => searchStore.okToSearch ? searchStore.find() : null
</script>

<template>
    <button
        @click="enterMethod"
        :disabled="!searchStore.okToSearch"
        class="
            text-black hover:text-gray-800 fill-black hover:fill-gray-800
            relative cursor-pointer flex items-center justify-center
            h-icon w-[19px]
        "
        :class="{
            'opacity-30 pointer-events-none': !searchStore.okToSearch
        }"
    >
        <MagnifyingGlass />
    </button>
</template>
