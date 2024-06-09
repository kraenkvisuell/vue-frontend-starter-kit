export function useIterable() {
    function isIterable(item) {
        // checks for null and undefined
        if (item == null) {
            return false
        }

        return typeof item[Symbol.iterator] === 'function'
    }

    function ensureIterable(item) {
        if (!isIterable(item)) return []

        return item
    }

    return { isIterable, ensureIterable }
}
