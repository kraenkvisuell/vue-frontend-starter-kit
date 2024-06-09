export default {
    getLink: (type, linked_page, linked_product) => {
        if (type.value === 'shop') {
            return '/shop';
        } else if (type.value === 'page' && linked_page.url) {
            return linked_page.url;
        } else if (type.value === 'product' && linked_product.url) {
            return linked_product.url;
        }

        return '';
    },

    stripTags(text) {
        text = text ? text : ''
        let doc = new DOMParser().parseFromString(text, 'text/html')
        return doc.body.textContent || ''
    },

    nl2br(str) {
        let replaceStr = '$1<br />$2';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
    },

    ensureUrl(str) {
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
    },
}
