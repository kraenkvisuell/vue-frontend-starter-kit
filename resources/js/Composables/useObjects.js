export function useObjects() {
    function flattenProxy(obj) {
        return JSON.parse(JSON.stringify(obj))
    }

    return { flattenProxy }
}
