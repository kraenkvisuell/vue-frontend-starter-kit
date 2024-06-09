export function useStrings() {
    function makeId(length = 12) {
        let result = ''
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
        const charactersLength = characters.length
        let counter = 0
        while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength))
            counter += 1
        }
        return result
    }

    function nl2br(str) {
        let replaceStr = '$1<br />$2'
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr)
    }

    function stripTags(text) {
        text = text ? text : ''
        let doc = new DOMParser().parseFromString(text, 'text/html')
        return doc.body.textContent || ''
    }

    function ucfirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

    function validateEmail($email) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
        return reg.test($email)
    }

    return { makeId, nl2br, stripTags, ucfirst, validateEmail }
}
