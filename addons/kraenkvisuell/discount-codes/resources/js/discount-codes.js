import DiscountCodeUsages from './components/fieldtypes/DiscountCodeUsages.vue'
import DiscountCodeUsagesIndex from './components/fieldtypes/DiscountCodeUsagesIndex.vue'

Statamic.booting(() => {
    Statamic.$components.register('discount_code_usages-fieldtype', DiscountCodeUsages)
    Statamic.$components.register('discount_code_usages-fieldtype-index', DiscountCodeUsagesIndex)
})


