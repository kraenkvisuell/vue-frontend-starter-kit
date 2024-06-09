import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import { useModalStore } from './ModalStore'
import _ from 'lodash'
import axios from 'axios'

export const useSearchStore = defineStore('search', () => {
    const modalStore = useModalStore()

    const isOpen = ref(false)
    const isSearching = ref(false)
    const hasSearched = ref(false)
    const needle = ref('')
    const lastNeedle = ref('')
    const results = ref([])

    const okToSearch = computed(() => {
        return _.trim(needle.value).length > 1
    })

    const close = () => {
        modalStore.close('searchModal')
    }

    const find = () => {
        modalStore.open('searchModal')
        isSearching.value = true
        lastNeedle.value = needle.value

        axios.post(route('store.search', [$shared.locale]), {
            needle: _.trim(needle.value),
        }).then((response) => {
            results.value = response.data
            isSearching.value = false
            hasSearched.value = true

        }).catch((error) => {
            console.log(error)
            isSearching.value = false
            hasSearched.value = true
        })
    }


    return {
        isOpen,
        isSearching,
        hasSearched,
        needle,
        lastNeedle,
        results,
        okToSearch,
        close,
        find,
    }
})
