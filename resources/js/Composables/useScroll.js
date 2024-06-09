export function useScroll() {
    function scrollToTop() {
        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        })
    }
    
    return {scrollToTop}
}
