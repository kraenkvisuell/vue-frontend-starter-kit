import _ from 'lodash'

export function useMedia() {
    function imageLink(image, options = {}) {
        if (!image) {
            return ''
        }

        let disk = image.disk ? image.disk : 'assets'
        let cdnPrefix = $shared.imgCdnUrl + disk + '/'

        if (image.extension === 'svg') {
            return cdnPrefix + image.path
        }

        options.originalExtension = image.extension

        if (!(options.format)) {
            options.format = 'webp'
        }

        if (!(options.crop)) {
            options.crop = false
        }

        let transformations = []

        if (options.quality) {
            transformations.push('quality=' + options.quality)
        }

        if (options.position) {
            transformations.push('focus=' + options.position)
        }

        if (options.output) {
            transformations.push('output=' + options.output)
        }

        if (options.crop && options.fit) {
            transformations.push('cover-max=' + options.fit.join('x'))
        } else if (options.fit) {
            transformations.push('contain-max=' + options.fit.join('x'))
        } else if (options.width) {
            transformations.push('resize=' + options.width)
        }


        let url = $shared.twicpicUrls[disk] + '/' + image.path + '?twic=v1/' + transformations.join('/')

        return url
    }

    function localImageLink(image, options = {}) {
        if (!image) {
            return ''
        }

        let disk = image.disk ? image.disk : 'assets'
        let cdnPrefix = $shared.imgCdnUrl + disk + '/'


        if (image.extension === 'svg') {
            return cdnPrefix + image.path
        }

        options.originalExtension = image.extension

        if (!(options.format)) {
            options.format = 'webp'
        }

        if (!(options.quality)) {
            options.quality = 90
        }

        let newOptions = []
        _.each(options, (value, key) => {
            newOptions.push(key + '=' + value)
        })

        newOptions.sort()


        let path = image.path
        if (options.format !== options.originalExtension) {
            path = path.replace('.' + options.originalExtension, '.' + options.format)
        }

        return '/' + $shared.optimizedImgUrl + '/' + disk + '/' + newOptions.join('|') + '/' + path
    }

    function fileLink(file) {
        let disk = file.disk ? file.disk : 'assets'

        return $shared.imgCdnUrl + disk + '/' + file.path
    }

    function videoLink(file) {
        let disk = file.disk ? file.disk : 'assets'
        return $shared.imgCdnUrl + disk + '/' + file.path

        // let transformations = [];
        //
        // if (file.mime_type === 'video/webm') {
        //     transformations.push('output=vp9');
        // } else {
        //     transformations.push('output=h264');
        // }
        //
        //
        // let url = $shared.twicpicUrls[disk + '-videos'] + '/' + file.path + '?twic=v1/' + transformations.join('/');
        //
        // return url;
    }

    return { imageLink, localImageLink, fileLink, videoLink }
}
