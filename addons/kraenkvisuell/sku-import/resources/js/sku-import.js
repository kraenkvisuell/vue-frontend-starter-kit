import SkuImport from './components/SkuImport.vue'


Statamic.booting(() => {
    Statamic.$components.register('sku-import', SkuImport)
})


