<script setup>
import { storeToRefs } from 'pinia'
import TextField from '../../Forms/TextField.vue'
import { useSearchStore } from '../../Stores/SearchStore'

const searchStore = useSearchStore()
const { needle } = storeToRefs(searchStore)

const enterMethod = () => searchStore.okToSearch ? searchStore.find() : null
</script>

<template>
    <TextField
        :placeholder="$trans.shop.search"
        :enterMethod="enterMethod"
        v-model="needle"
        name="needle"
    />
</template>
