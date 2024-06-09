import { defineStore } from 'pinia'
import _ from 'lodash'
import axios from 'axios'
import { computed, ref } from 'vue'
import { useDebounce } from '../Composables/useDebounce.js'
import { useStrings } from '../Composables/useStrings.js'

export const useProductStore = defineStore('productStore', () => {
    const { debounce } = useDebounce()
    const { stripTags } = useStrings()

    const matchingSkus = ref([])
    const loadingMatchingSkus = ref(false)
    const loadingSimilarSkus = ref(false)
    const okToListenToSlideChange = ref(false)
    const product = ref({})
    const selectedSkuId = ref(0)
    const selectedPerspective = ref('')
    const similarSkus = ref([])

    const fallBackImages = computed(() => {
        let images = []
        _.forEach(product.value.skus, (sku) => {
            _.forEach(sku.images, (image) => {
                images.push(image)
            })
        })

        images = _.uniqBy(images, 'perspective')

        return images
    })

    const fallBackVideo = computed(() => {
        let fallbackVideo = null

        _.forEach(product.value.skus, (sku) => {
            if (sku.videos.length && !fallbackVideo) {
                fallbackVideo = sku.videos[0]
            }
        })

        return fallbackVideo
    })

    const currentDetailImages = computed(() => {
        let selectedSku = _.find(product.value.skus, (item) => item.id === selectedSkuId.value)

        let images = _.map(fallBackImages.value, (item) => {
            let ownImage = _.find(selectedSku.images, (image) => image.perspective === item.perspective)

            return ownImage ? ownImage : item
        })

        if (selectedSku) {
            if (selectedSku.videos.length) {
                images.push(selectedSku.videos[0])
            } else if (fallBackVideo.value) {
                images.push(fallBackVideo.value)
            }
        }

        return images
    })

    const seoTitle = computed(() => {
        if (product.value.seo_title) {
            return product.value.seo_title
        }

        return product.value.tags_string
            + ' / ' + product.value.group_title
            + ' ' + product.value.reduced_title
            + ' / ' + $shared.websiteName
    })

    const ogTitle = computed(() => {
        if (product.value.og_title && product.value.og_title.text) {
            return product.value.og_title.text
        }

        return seoTitle.value
    })

    const seoDescription = computed(() => {
        if (product.value.seo_description) {
            return product.value.seo_description
        }

        return _.truncate(stripTags(product.value.description), {
            'length': 150,
            'separator': ' ',
        })
    })

    const ogDescription = computed(() => {
        if (product.value.og_description) {
            return product.value.og_description
        }

        return seoDescription.value
    })

    const ogImage = computed(() => {
        if (product.value.og_image && product.value.og_image.is_image) {
            return product.value.og_image
        }

        return null
    })

    const selectedSku = computed(() => {
        if (product.value && product.value.skus && selectedSkuId.value) {
            return product.value.skus.find(sku => sku.id === selectedSkuId.value)
        }

        return {}
    })

    const twitterCardImage = computed(() => {
        if (product.value.twitter_card_image && product.value.twitter_card_image.is_image) {
            return product.value.twitter_card_image
        }

        return ogImage.value
    })

    const checkHash = () => {
        let hash = window.location.hash
        if (hash && hash.length > 1) {
            selectSkuBySlug(hash.substring(1))

        } else {
            selectFirstSku()
        }
    }

    const loadMatchingSkus = () => {
        loadingMatchingSkus.value = true

        axios.get(route('matching-skus', [$shared.locale, selectedSkuId.value])).then((response) => {
            matchingSkus.value = response.data
            loadingMatchingSkus.value = false
        }).catch((error) => {
            console.log(error)
        })
    }

    const loadSimilarSkus = () => {
        loadingSimilarSkus.value = true

        axios.get(route('similar-skus', [$shared.locale, selectedSkuId.value])).then((response) => {
            similarSkus.value = response.data
            loadingSimilarSkus.value = false
        }).catch((error) => {
            console.log(error)
        })
    }

    const selectFirstSku = () => {
        let sku = product.value.skus[0]
        selectSkuId(sku.id, sku.slug)
    }

    const selectSkuBySlug = (slug) => {
        let selectedOne = false
        _.each(product.value.skus, (sku) => {
            if (!selectedOne && _.findIndex(sku.colors, { slug: slug }) > -1) {
                selectSkuId(sku.id, slug)
                selectedOne = true
            }
        })
        if (!selectedOne) {
            let sku = product.value.skus[0]
            selectSkuId(sku.id, slug)
        }
    }

    const activateSlideChangeListener = () => {
        okToListenToSlideChange.value = true
    }

    const deactivateSlideChangeListener = () => {
        okToListenToSlideChange.value = false
    }

    const selectSkuId = (skuId, colorSlug) => {
        if (skuId && skuId !== selectedSkuId.value) {
            selectedSkuId.value = skuId
            //history.pushState(null, null, '#' + colorSlug)
            debouncedLoadOthers()
        }
    }

    const selectPerspective = (perspective) => {
        selectedPerspective.value = perspective
    }

    const debouncedLoadOthers = debounce(() => {
        loadMatchingSkus()
        loadSimilarSkus()
    }, 1000)

    const updateProduct = (newProduct) => {
        product.value = newProduct
    }

    return {
        matchingSkus,
        loadingMatchingSkus,
        loadingSimilarSkus,
        product,
        selectedSkuId,
        selectedPerspective,
        similarSkus,
        okToListenToSlideChange,
        fallBackImages,
        fallBackVideo,
        debouncedLoadOthers,
        currentDetailImages,
        seoTitle,
        ogTitle,
        seoDescription,
        ogDescription,
        ogImage,
        twitterCardImage,
        selectedSku,
        checkHash,
        loadMatchingSkus,
        loadSimilarSkus,
        selectFirstSku,
        selectSkuBySlug,
        deactivateSlideChangeListener,
        activateSlideChangeListener,
        selectSkuId,
        selectPerspective,
        updateProduct,
    }
})
