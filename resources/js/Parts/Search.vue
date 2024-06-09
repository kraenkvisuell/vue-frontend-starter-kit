<script setup>
import { Link } from '@inertiajs/vue3'
import Modal from '../Shared/Modal.vue'
import { useMenuStore } from '../Stores/MenuStore'
import { useModalStore } from '../Stores/ModalStore'
import { useSearchStore } from '../Stores/SearchStore'
import { useTranslations } from '../Composables/useTranslations'
import SearchField from './Menu/SearchField.vue'
import SearchIcon from './Menu/SearchIcon.vue'

const modalStore = useModalStore()
const searchStore = useSearchStore()
const menuStore = useMenuStore()
const { replace } = useTranslations()

const handleResultClick = () => {
    searchStore.close()
    menuStore.close()
}
</script>

<template>
    <Modal id="searchModal">
        <div
            class="
                px-[15px] md:px-[20px] pt-[60px] md:pt-[30px] pb-[30px] flex flex-col items-center gap-[40px]
                transition-opacity
            "
            :class="{
            'opacity-50': searchStore.isSearching,
            'opacity-full': !searchStore.isSearching,
            }"
        >
            <div class="w-full flex justify-center items-center gap-[10px]">
                <div class="w-full max-w-[300px]">
                    <SearchField />
                </div>

                <div class="mt-[2px]">
                    <SearchIcon />
                </div>
            </div>

            <div
                v-show="searchStore.isSearching"
                class="w-full text-center max-w-screen-sm italic"
            >
                <p v-html="replace(
                    $trans.shop.searching_for_placeholder,
                    {'needle': '&quot;'+searchStore.lastNeedle+'&quot;'}
                )+'...'" />
            </div>

            <div
                v-show="
                    !searchStore.isSearching
                    && !searchStore.results.length
                    && searchStore.hasSearched
                    && searchStore.lastNeedle
                "
                class="w-full text-center max-w-screen-sm"
            >
                <p v-html="replace(
                    $trans.shop.no_results_found_placeholder,
                    {'needle': '&quot;'+searchStore.lastNeedle+'&quot;'}
                )" />
            </div>

            <div v-show="!searchStore.isSearching && searchStore.results.length" class="w-full max-w-screen-sm">
                <div class="font-bold mb-[15px]">
                    {{ $trans.shop.search_results }}
                </div>

                <div class="grid gap-[30px]">
                    <div v-for="batch in searchStore.results" class="bg-white px-[20px] py-[15px] ">
                        <Link
                            :href="result.url"
                            v-for="(result, index) in batch.results"
                            class="block py-[5px] text-copy-sm"
                            @click="handleResultClick"
                        >
                            {{ result.title }}
                        </Link>

                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

