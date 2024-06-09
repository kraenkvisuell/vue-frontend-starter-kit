<script setup>
import ShopButton from './Shop/ShopButton.vue'
import ButtonWithTagLink from './Shop/ButtonWithTagLink.vue'
import ButtonWithTags from './Shop/ButtonWithTags.vue'
import CategoryWithTags from './Shop/CategoryWithTags.vue'
import Filters from './ShopNavi/Filters.vue'
import ShopProductGroupLink from '../../Shared/ShopProductGroupLink.vue'
import _ from 'lodash'
import { computed } from 'vue'
import { useShopStore } from '../../Stores/ShopStore'
import { useStrings } from '../../Composables/useStrings.js'

const { ucfirst } = useStrings()

const shopStore = useShopStore()

const firstCategories = computed(() => {
    return _.take($shared.categories, Math.floor($shared.categories.length / 2))
})

const secondCategories = computed(() => {
    return _.slice($shared.categories, Math.floor($shared.categories.length / 2))
})

const onlyNewTitle = computed(() => {
    let month = new Date().getMonth()

    return [0, 1, 6, 7].indexOf(month) > -1 ? $trans.shop.new_arrivals : $trans.shop.current_season
})

const categoryIsActive = (category) => {
    if (!category && !shopStore.selectedCategory) {
        return true
    }

    return shopStore.selectedCategory === category.slug
}

const productGroupIs = (slug) => {
    return shopStore.selectedProductGroup === slug
}
</script>

<template>
    <div class="w-full h-full lg:pb-[70px] overflow-auto">
        <div class="grid gap-[30px]">
            <div>
                <div class="grid grid-cols-2 items-start sm:grid-cols-1 gap-[20px] sm:gap-0 sm:mt-[-1px]">
                    <div class="col-span-2 sm:col-span-1">
                        <ShopButton
                            :text="ucfirst($trans.shop.all_categories)"
                            :url="$route('shop', [$shared.locale])"
                            :isActive="categoryIsActive('')
                                && !shopStore.productGroupsAreOpen && !shopStore.onlyNewIsActive"
                            :isShop="true"
                        />
                    </div>

                    <div>
                        <template v-for="category in firstCategories">
                            <CategoryWithTags
                                v-if="category.tags.length > 1"
                                :category="category"
                                :url="$route('shop.category', [$shared.locale, category.slug])"
                                :isActive="categoryIsActive(category)"
                                :activeTag="shopStore.selectedTag"
                            />

                            <ShopButton
                                v-else
                                :text="category.title"
                                :url="$route('shop.category', [$shared.locale, category.slug])"
                                :isActive="categoryIsActive(category)"
                                :isShop="true"
                            />
                        </template>
                    </div>

                    <div>
                        <template v-for="category in secondCategories">
                            <CategoryWithTags
                                v-if="category.tags.length > 1"
                                :category="category"
                                :url="$route('shop.category', [$shared.locale, category.slug])"
                                :isActive="categoryIsActive(category)"
                                :activeTag="shopStore.selectedTag"
                            />

                            <ShopButton
                                v-else
                                :text="category.title"
                                :url="$route('shop.category', [$shared.locale, category.slug])"
                                :isActive="categoryIsActive(category)"
                                :isShop="true"
                            />
                        </template>
                    </div>
                </div>

                <div>
                    <ButtonWithTags
                        :isActive="shopStore.productGroupsAreOpen"
                        :activeTag="shopStore.selectedProductGroup"
                    >
                        <template v-slot:label>
                            <button @click="shopStore.openProductGroups()">{{ $trans.shop.collections }}</button>
                        </template>

                        <template v-slot:options>
                            <div class="grid grid-cols-3 sm:grid-cols-1 md:grid-cols-2">
                                <ShopProductGroupLink
                                    v-for="productGroup in $shared.productGroups"
                                    :href="$route('shop.product-group', [$shared.locale, productGroup.slug])"
                                >
                                    <ButtonWithTagLink
                                        :isActive="productGroupIs(productGroup.slug)"
                                    >
                                        {{ productGroup.title }}
                                    </ButtonWithTagLink>
                                </ShopProductGroupLink>
                            </div>
                        </template>
                    </ButtonWithTags>
                </div>

                <ShopButton
                    :text="onlyNewTitle"
                    :url="$route('shop.new', [$shared.locale])"
                    :isActive="shopStore.onlyNewIsActive"
                    :isShop="true"
                />
            </div>

            <Filters />
        </div>
    </div>

    <div
        class="
            hidden lg:block absolute bottom-0 left-0 z-10 w-full h-[40px]
            bg-gradient-to-t from-gray-100 to-transparent pointer-events-none
        "
    />
</template>
