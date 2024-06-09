import ShopColor from './components/fieldtypes/ShopColor.vue'

Statamic.booting(() => {
    Statamic.$components.register('shop_color-fieldtype', ShopColor)
})


