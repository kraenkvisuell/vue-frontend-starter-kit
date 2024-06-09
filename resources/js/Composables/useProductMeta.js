import _ from 'lodash'
import { useStrings } from './useStrings.js'

export function useProductMeta() {
    const { stripTags } = useStrings()

    const metaSource = (product) => {
        let ogImage = null
        let ogImageRatio = ''

        if (product.images && product.images.length) {
            ogImage = product.images[0]
            ogImageRatio = 'square'
        }

        let description = product.seo_description

        if (!description) {
            description = _.truncate(stripTags(product.description), {
                'length': 150,
                'separator': ' ',
            })
        }

        let title = product.seo_title

        if (!title) {
            title = $shared.websiteName
                + ' / ' + product.tags_string + ' / ' + product.group_title + ' ' + product.reduced_title
        }

        return {
            seo_title: { text: title },
            seo_description: { text: description },
            og_image: ogImage,
            og_image_ratio: ogImageRatio,
        }
    }

    return { metaSource }
}
