import { defineStore } from 'pinia'
import { usePage } from '@inertiajs/vue3'
import nprogress from 'nprogress'
import _ from 'lodash'
import store from 'store2'
import { ref, computed } from 'vue'

export const useShopStore = defineStore('shop', () => {
    const allSizes = [
        {
            value: 's',
            label: $trans.shop.small,
        },
        {
            value: 'm',
            label: $trans.shop.medium,
        },
        {
            value: 'l',
            label: $trans.shop.large,
        },
    ]

    const backRoute = ref('')
    const onlyNewIsActive = ref(false)
    const filterIsOpen = ref({ productGroup: false, colorGroup: false })
    const filtersAreOpen = ref(false)
    const selectableColorGroups = ref([])
    const productGroupsAreOpen = ref(false)
    const selectableSizes = ref([])
    const products = ref([])
    const selectedCategory = ref('')
    const selectedProductGroup = ref('')
    const selectedFilters = ref({
        colorGroup: null,
        size: null,
        sortBy: { value: 'alphabetical_asc', label: $trans.shop.alphabetical_asc },
    })
    const selectedSkuId = ref({})
    const selectedTag = ref('')
    const sortBys = ref([
        {
            value: 'alphabetical_asc',
            label: $trans.shop.alphabetical_asc,
        },
        {
            value: 'alphabetical_desc',
            label: $trans.shop.alphabetical_desc,
        },
        {
            value: 'price_asc',
            label: $trans.shop.price_asc,
        },
        {
            value: 'price_desc',
            label: $trans.shop.price_desc,
        },
        {
            value: 'size_asc',
            label: $trans.shop.size_asc,
        },
        {
            value: 'size_desc',
            label: $trans.shop.size_desc,
        },
    ])

    const currentProductGroup = computed(() => {
        if (selectedProductGroup.value) {
            let productGroup = _.find($shared.productGroups, (productGroup) => productGroup.slug === selectedProductGroup.value)

            if (productGroup) {
                return productGroup
            }
        }

        return {}
    })

    const currentCategory = computed(() => {
        if (selectedCategory.value) {
            let category = _.find($shared.categories, (category) => category.slug === selectedCategory.value)

            if (category) {
                return category
            }
        }

        return {}
    })

    const currentTag = computed(() => {
        if (selectedTag.value) {
            let tag = _.find($shared.tags, (tag) => tag.slug === selectedTag.value)

            if (tag) {
                return tag
            }
        }

        return {}
    })

    const init = () => {
        initFilters()
        updateSelectableColorGroups()
        updateSelectableSizes()
        onlyNewIsActive.value = store.get('onlyNewIsActive', '')
        selectedCategory.value = store.get('selectedCategory', '')
        selectedTag.value = store.get('selectedTag')
        selectedProductGroup.value = store.get('selectedProductGroup', '')
    }

    const clear = () => {
        clearAllFilters()
        selectedCategory.value = ''
        selectedTag.value = ''
        selectedProductGroup.value = ''
    }

    const initProducts = (newProducts) => products.value = newProducts

    const sortProducts = () => {
        nprogress.start()
        let arr = selectedFilters.value.sortBy.value.split('_')
        let sortBy = arr[0]
        let direction = arr[1]

        if (sortBy === 'alphabetical') {
            products.value = _.orderBy(products.value, function(p) {
                return p.title
            }, direction)
        }

        if (sortBy === 'price') {
            products.value = _.orderBy(products.value, function(p) {
                return p.skus[0].price
            }, direction)
        }

        if (sortBy === 'size') {
            products.value = _.orderBy(products.value, function(p) {
                return p.size_number
            }, direction)
        }
        nprogress.done()
    }

    const initFilters = () => {
        _(selectedFilters.value).each((value, filterName) => {
            const stored = store.get(filterName)
            if (stored) {
                selectedFilters.value[filterName] = stored
            }
        })
        sortProducts()
    }

    const updateSelectableColorGroups = () => {
        selectableColorGroups.value = _(usePage().props.colorGroups)
        .filter((colorGroup) => {
            return (!selectedCategory.value || _.find(colorGroup.categories, { 'slug': selectedCategory.value }))
                && (!selectedTag.value || _.find(colorGroup.tags, { 'slug': selectedTag.value }))
                && (
                    !selectedFilters.value.productGroup
                    || _.find(colorGroup.productGroups, { 'slug': selectedFilters.value.productGroup.value })
                )

        }).map((colorGroup) => {
            return {
                value: colorGroup.id,
                label: colorGroup.title,
                color: colorGroup.color,
            }
        }).value()
    }

    const updateSelectableSizes = () => selectableSizes.value = allSizes

    const changeCategory = (category, tag) => {
        nprogress.start()
        if (
            category !== store.get('selectedCategory', '')
            || tag !== store.get('selectedTag', '')
        ) {
            clearAllFilters()
        }

        productGroupsAreOpen.value = false
        selectedProductGroup.value = ''
        store.set('selectedProductGroup', '')

        onlyNewIsActive.value = false
        store.set('onlyNewIsActive', false)

        selectedCategory.value = category
        store.set('selectedCategory', category)

        selectedTag.value = tag
        store.set('selectedTag', tag)
        updateSelectableColorGroups()
        nprogress.done()
    }

    const activateOnlyNew = () => {
        changeCategory('', '')
        onlyNewIsActive.value = true
        store.set('onlyNewIsActive', true)


    }

    const toggleFilters = () => filtersAreOpen.value = !filtersAreOpen.value

    const closeFilters = () => filtersAreOpen.value = false

    const changeFilter = (filterName, option) => {
        nprogress.start()
        selectedFilters.value[filterName] = option
        store.set(filterName, option)
        closeFilter(filterName)

        if (filterName === 'productGroup') {
            clearFilter('colorGroup')
            clearFilter('size')
            updateSelectableColorGroups()
        }
        nprogress.done()

        if (filterName === 'sortBy') {
            sortProducts()
        }
    }

    const clearAllFilters = () => {
        _(filterIsOpen.value).each((value, filterName) => {
            if (filterName !== 'sortBy') {
                clearFilter(filterName)
            }
        })
    }

    const clearFilter = (filterName) => {
        nprogress.start()
        selectedFilters.value[filterName] = null
        store.remove(filterName)
        closeFilter(filterName)
        if (filterName === 'productGroup') {
            clearFilter('colorGroup')
            updateSelectableColorGroups()
        }
        nprogress.done()
    }

    const toggleFilter = (filterName) => filterIsOpen.value[filterName] = !filterIsOpen.value[filterName]

    const closeFilter = (filterName) => filterIsOpen.value[filterName] = false

    const selectSkuId = (productId, skuId) => selectedSkuId.value[productId] = skuId

    const openProductGroups = () => {
        changeCategory('', '')
        productGroupsAreOpen.value = true
    }

    const selectProductGroup = (productGroupSlug) => {
        productGroupsAreOpen.value = true

        selectedProductGroup.value = productGroupSlug

        store.set('selectedProductGroup', productGroupSlug)
    }

    return {
        onlyNewIsActive,
        backRoute,
        filterIsOpen,
        filtersAreOpen,
        products,
        productGroupsAreOpen,
        selectableColorGroups,
        selectableSizes,
        selectedCategory,
        selectedProductGroup,
        selectedFilters,
        selectedSkuId,
        selectedTag,
        sortBys,
        currentProductGroup,
        currentCategory,
        currentTag,
        changeCategory,
        changeFilter,
        clear,
        clearAllFilters,
        clearFilter,
        closeFilter,
        closeFilters,
        init,
        initFilters,
        initProducts,
        selectSkuId,
        sortProducts,
        activateOnlyNew,
        toggleFilter,
        toggleFilters,
        updateSelectableColorGroups,
        updateSelectableSizes,
        openProductGroups,
        selectProductGroup,
    }
})
