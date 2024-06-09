export function useMerchantMenu() {
    const pages = [
        {
            title: $trans.shop.order_form,
            url: route('merchants.order-form')
        },
        {
            title: $trans.shop.news,
            url: route('merchants.news')
        }
    ]

    return {pages}
}
