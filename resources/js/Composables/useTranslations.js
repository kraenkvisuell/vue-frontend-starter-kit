import _ from 'lodash'

export function useTranslations() {
    function replace(str, map = {}) {
        _.forEach(map, (val, key) => str = str.replace(':' + key, val))

        return str
    }

    return {replace}
}
