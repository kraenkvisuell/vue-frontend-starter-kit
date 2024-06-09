import {defineStore} from 'pinia'
import {computed, ref} from 'vue'
import _ from 'lodash'
import {usePage} from '@inertiajs/vue3'

export const useOrderFormStore = defineStore('orderFormStore', () => {
    const volumeSizes = {
        mini: 2,
        small: 6,
        medium: 9,
    }

    const productGroups = ref(usePage().props.productGroups)
    const openProductGroups = ref([])
    const openProducts = ref([])
    const listAllSkus = ref(false)
    const filteredByKind = ref('all')
    const filteredByCategory = ref('all')
    const filteredByVolume = ref('all')
    const filteredByColorGroup = ref('all')
    const filteredByOnlyAvailable = ref(false)

    const kindOptions = computed(() => {
        return [
            {
                label: $trans.shop.nos_and_preorder,
                value: 'all',
            },
            {
                label: $trans.shop.only_preorder,
                value: 'only_preorder',
            },
            {
                label: $trans.shop.only_new,
                value: 'only_new',
            },
        ]
    })

    const categoryOptions = computed(() => {
        let options = [
            {
                label: $trans.shop.all_categories,
                value: 'all',
            }
        ];

        _.forEach($shared.categories, (category) => {
            options.push({
                label: category.title,
                value: category.slug,
            })
        })

        return options;
    })

    const volumeOptions = computed(() => {
        return [
            {
                label: $trans.shop.all_sizes,
                value: 'all',
            },
            {
                label: '< 2 L (' + $trans.shop.mini + ')',
                value: 'mini',
            },
            {
                label: '2 - 6 L (' + $trans.shop.small + ')',
                value: 'small',
            },
            {
                label: '> 6 - 9 L (' + $trans.shop.medium + ')',
                value: 'medium',
            },
            {
                label: '> 9 L (' + $trans.shop.large + ')',
                value: 'large',
            },
        ]
    })

    const colorGroupOptions = computed(() => {
        let options = [
            {
                label: $trans.shop.all_colors,
                value: 'all',
            }
        ];

        _.forEach(_.sortBy(usePage().props.colorGroupOptions, 'label'), (option) => {
            options.push({
                label: option.label === 'xxxx' ? 'N/A' : option.label,
                value: option.value,
            })
        })

        return options
    })

    const showableProductGroups = computed(() => {
        return _.filter(productGroups.value, (productGroup) => {
            if (filteredByKind.value === 'only_preorder') {
                if (!_.filter(productGroup.products, (product) => _.find(product.skus, (sku) => sku.is_preorder)).length) {
                    return false
                }
            }

            if (filteredByKind.value === 'only_new') {
                if (!_.filter(productGroup.products, (product) => _.find(product.skus, (sku) => sku.is_new)).length) {
                    return false
                }
            }

            if (filteredByOnlyAvailable.value) {
                if (!_.filter(productGroup.products, (product) => {
                    return _.find(product.skus, (sku) => sku.availability === 'available')
                }).length) {
                    return false
                }
            }

            if (filteredByCategory.value !== 'all') {
                if (!_.find(productGroup.categories, (groupCategory) => groupCategory.slug === filteredByCategory.value)) {
                    return false
                }
            }

            if (filteredByVolume.value !== 'all') {
                if (filteredByVolume.value === 'large') {
                    if (!_.find(productGroup.products, (product) => product.integer_volume > volumeSizes.medium)) {
                        return false
                    }
                } else if (filteredByVolume.value === 'medium') {
                    if (!_.find(productGroup.products, (product) => {
                        return product.integer_volume <= volumeSizes.medium && product.integer_volume > volumeSizes.small
                    })) {
                        return false
                    }
                } else if (filteredByVolume.value === 'small') {
                    if (!_.find(productGroup.products, (product) => {
                        return product.integer_volume <= volumeSizes.small && product.integer_volume >= volumeSizes.mini
                    })) {
                        return false
                    }
                } else if (filteredByVolume.value === 'mini') {
                    if (!_.find(productGroup.products, (product) => product.integer_volume < volumeSizes.mini)) {
                        return false
                    }
                }
            }

            if (filteredByColorGroup.value !== 'all') {
                if (!_.filter(productGroup.products, (product) => {
                    return _.find(product.skus, (sku) => sku.color_group_slug === filteredByColorGroup.value)
                }).length) {
                    return false
                }
            }

            return true
        })
    })

    const showableProducts = computed(() => {
        let products = []

        _.forEach(productGroups.value, (productGroup) => {
            _.forEach(productGroup.products, (product) => {
                if (productIsShowable(product)) {
                    products.push(product)
                }
            })
        })

        return products
    })

    const showableSkus = computed(() => {
        let skus = []

        _.forEach(showableProducts.value, (showableProduct) => {
            _.forEach(showableProduct.skus, (sku) => {
                if (skuIsVisibleByProduct(showableProduct, sku)) {
                    skus.push(sku)
                }
            })
        })

        return skus
    })

    const toggleProductGroup = (id) => {
        if (_.find(openProductGroups.value, (item) => item === id)) {
            openProductGroups.value = _.filter(openProductGroups.value, (item) => item !== id)
        } else {
            openProductGroups.value.push(id)
        }
    }

    const toggleProduct = (id) => {
        if (_.find(openProducts.value, (item) => item === id)) {
            openProducts.value = _.filter(openProducts.value, (item) => item !== id)
        } else {
            openProducts.value.push(id)
        }
    }

    const showProductGroup = (productGroup) => {
        if (listAllSkus.value) {
            return false
        }

        return _.find(showableProductGroups.value, (item) => item.id === productGroup.id)
    }

    const showProduct = (product, productGroup) => {
        if (listAllSkus.value) {
            return false
        }

        if (!_.find(openProductGroups.value, (item) => item === productGroup.id)) {
            return false
        }

        return _.find(showableProducts.value, (item) => item.id === product.id)
    }

    const showSku = (sku, product, productGroup) => {
        if (
            !listAllSkus.value &&
            (
                !_.find(openProductGroups.value, (item) => item === productGroup.id)
                || !_.find(openProducts.value, (item) => item === product.id)
            )
        ) {
            return false
        }

        return _.find(showableSkus.value, (item) => item.id === sku.id)
    }

    const productIsShowable = (product) => {
        if (filteredByKind.value === 'only_preorder' && !_.find(product.skus, (sku) => sku.is_preorder)) {
            return false
        }

        if (filteredByKind.value === 'only_new' && !_.find(product.skus, (sku) => sku.is_new)) {
            return false
        }

        if (
            filteredByCategory.value !== 'all'
            && !productIsVisibleByCategory(filteredByCategory.value, product)
        ) {
            return false
        }

        if (filteredByOnlyAvailable.value && !_.find(product.skus, (sku) => sku.availability === 'available')) {
            return false
        }

        if (filteredByVolume.value !== 'all') {
            if (!productIsVisibleByVolume(filteredByVolume.value, product)) {
                return false
            }
        }

        if (
            filteredByColorGroup.value !== 'all'
            && !_.find(product.skus, (sku) => sku.color_group_slug === filteredByColorGroup.value)
        ) {
            return false
        }

        return true
    }

    const skuIsVisibleByProduct = (product, sku) => {
        if (filteredByKind.value === 'only_preorder' && !sku.is_preorder) {
            return false
        }

        if (filteredByKind.value === 'only_new' && !sku.is_new) {
            return false
        }

        if (filteredByCategory.value !== 'all') {
            if (!productIsVisibleByCategory(filteredByCategory.value, product)) {
                return false
            }
        }

        if (filteredByOnlyAvailable.value && sku.availability !== 'available') {
            return false
        }

        if (filteredByVolume.value !== 'all') {
            if (!productIsVisibleByVolume(filteredByVolume.value, product)) {
                return false
            }
        }

        if (filteredByColorGroup.value !== 'all' && sku.color_group_slug !== filteredByColorGroup.value) {
            return false
        }

        return true
    }

    const productIsVisibleByCategory = (category, product) => {
        return _.find(product.category_slugs, (slug) => slug === category)
    }

    const productIsVisibleByVolume = (volume, product) => {
        if (volume !== 'all') {
            if (volume === 'large') {
                if (product.integer_volume <= volumeSizes.medium) {
                    return false
                }
            } else if (volume === 'medium') {
                if (product.integer_volume > volumeSizes.medium || product.integer_volume <= volumeSizes.small) {
                    return false
                }
            } else if (volume === 'small') {
                if (product.integer_volume > volumeSizes.small || product.integer_volume < volumeSizes.mini) {
                    return false
                }
            } else if (volume === 'mini') {
                if (product.integer_volume >= volumeSizes.mini) {
                    return false
                }
            }
        }

        return true
    }

    const imagesForProductGroup = (productGroup) => {
        let images = []
        let usedProducts = []

        _.forEach(productGroup.products, (product) => {
            _.forEach(product.skus, (sku) => {
                if (
                    !_.find(usedProducts, (item) => item === product.id)
                    && sku.image
                    && images.length < 3
                    && _.find(showableSkus.value, (item) => item.id === sku.id)
                ) {
                    images.push(sku.image)

                    usedProducts.push(product.id)
                }
            })
        })

        return images
    }

    const imagesForProduct = (product) => {
        let images = []

        _.forEach(product.skus, (sku) => {
            if (sku.image && images.length < 3 && _.find(showableSkus.value, (item) => item.id === sku.id)) {
                images.push(sku.image)
            }
        })

        return images
    }

    const productContainsPreorder = (product) => {
        let count = 0

        _.forEach(product.skus, (sku) => {
            if (sku.is_preorder && _.find(showableSkus.value, (item) => item.id === sku.id)) {
                count++
            }
        })

        return count
    }

    const productContainsNew = (product) => {
        let count = 0

        _.forEach(product.skus, (sku) => {
            if (sku.is_new && _.find(showableSkus.value, (item) => item.id === sku.id)) {
                count++
            }
        })

        return count
    }

    const productGroupContainsPreorder = (productGroup) => {
        let count = 0

        _.forEach(productGroup.products, (product) => {
            _.forEach(product.skus, (sku) => {
                if (sku.is_preorder && _.find(showableSkus.value, (item) => item.id === sku.id)) {
                    count++
                }
            })
        })

        return count
    }

    const productGroupContainsNew = (productGroup) => {
        let count = 0

        _.forEach(productGroup.products, (product) => {
            _.forEach(product.skus, (sku) => {
                if (sku.is_new && _.find(showableSkus.value, (item) => item.id === sku.id)) {
                    count++
                }
            })
        })

        return count
    }

    return {
        productGroups,
        openProductGroups,
        openProducts,
        listAllSkus,
        filteredByKind,
        filteredByCategory,
        filteredByVolume,
        filteredByColorGroup,
        filteredByOnlyAvailable,
        kindOptions,
        categoryOptions,
        volumeOptions,
        colorGroupOptions,
        showableProductGroups,
        showableProducts,
        showableSkus,
        toggleProductGroup,
        toggleProduct,
        showProductGroup,
        showProduct,
        showSku,
        imagesForProductGroup,
        imagesForProduct,
        productContainsPreorder,
        productContainsNew,
        productGroupContainsPreorder,
        productGroupContainsNew,
    }
})
