import _ from 'lodash'

export function useLinks() {
    function linkType(elem, prefix = '') {
        return elem[prefix + 'link_type'] ? elem[prefix + 'link_type'].value : ''
    }

    function getLink(elem, prefix = '') {
        let locale = document.documentElement.getAttribute('lang')
        let type = elem[prefix + 'link_type']
        let linkedPage = elem[prefix + 'linked_page']
        let linkedProduct = elem[prefix + 'linked_product']
        let linkedCategory = elem[prefix + 'linked_product_category']
        let linkedProductGroup = elem[prefix + 'linked_product_group']
        let linkedProductTag = elem[prefix + 'linked_product_tag']
        let externalUrl = elem[prefix + 'external_url']

        if (!type || !type.value) {
            return ''
        }

        if (type.value === 'shop') {
            if (_.size(linkedProductTag) > 0) {
                let actualLinkedCategory = {}

                if (_.size(linkedCategory) > 0) {
                    actualLinkedCategory = _.find($shared.categories, (cat) => {
                        return cat.id === linkedCategory[0] && _.find(cat.tags, (tag) => tag.id === linkedProductTag[0])
                    })
                }

                if (!actualLinkedCategory) {
                    actualLinkedCategory = _.find($shared.categories, (cat) => {
                        return _.find(cat.tags, (tag) => tag.slug === linkedProductTag.slug)
                    })
                }
                if (typeof (actualLinkedCategory) === 'undefined' || !actualLinkedCategory.slug) {
                    return '#'
                }


                return route('shop.tag', [locale, actualLinkedCategory.slug, linkedProductTag.slug])
            }

            if (_.size(linkedCategory) > 0) {
                return route('shop.category', [locale, linkedCategory.slug])
            }

            return '/' + locale + '/shop'
        } else if (type.value === 'page' && linkedPage && linkedPage.url) {
            return linkedPage.url
        } else if (type.value === 'product' && linkedProduct && linkedProduct.slug) {
            return route('products.show', [locale, linkedProduct.slug])
        } else if (type.value === 'external') {
            return ensureUrl(externalUrl)
        }

        return ''
    }

    function ensureUrl(str) {
        str = _.trim(str)

        if (
            str.toLowerCase().indexOf('://') === -1
            && str.toLowerCase().substring(0, 7) !== 'mailto:'
            && str.toLowerCase().substring(0, 7) !== 'tel:'
            && str.substring(0, 1) !== '/'
        ) {
            str = 'https://' + str
        }

        return str
    }

    return { linkType, getLink, ensureUrl }
}
