export function useRatio() {
    function ratioClasses(str) {
        let arr = str.split(':')

        if (arr.length < 2) {
            return ''
        }

        let w = parseInt(arr[0])
        let h = parseInt(arr[1])

        if (isNaN(w) || isNaN(h) || !w || !h) {
            return ''
        }

        return 'aspect-w-' + w + ' aspect-h-' + h
    }

    return { ratioClasses }
}
