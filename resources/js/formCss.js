export default {
    inputCss(formBg = 'grey', hasErrors = false) {
        return 'text-copy-base w-full px-[15px] py-[7px] border'
            + (formBg === 'grey' ? 'bg-white' : 'bg-gray-100')
            + (hasErrors ? 'border-dashed border-error' : 'border-transparent')

    },
}
