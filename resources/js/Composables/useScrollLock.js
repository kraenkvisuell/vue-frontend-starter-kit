export function useScrollLock() {
    function lockBody() {
        document.querySelector('body').classList.add('locked');
    }

    function unlockBody() {
        document.querySelector('body').classList.remove('locked');
    }

    return {lockBody, unlockBody}
}
