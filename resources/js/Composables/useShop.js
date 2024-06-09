export function useShop() {
    function scrollToProducts() {
        const productsElement = document.getElementById('products')

        let scrollPosition = productsElement.offsetTop

        scrollPosition = scrollPosition > 330 ? (scrollPosition - 20) : 0

        setTimeout(() => scrollTo({ top: scrollPosition, left: 0, behavior: 'smooth' }), 200)
    }
    
    return { scrollToProducts }
}
