// import {defineStore} from 'pinia'
// import axios from 'axios'
//
// const stripe = Stripe(usePage().props.stripePublicKey);
//
// export const loadingStripe = writable(false);
// export const stripeLoaded = writable(false);
// export const stripeCheckout = writable(null);
//
// export const loadStripe = async () => {
//     console.log('loadStripe')
//     loadingStripe.set(true)
//
//     const response = await axios.get('/stripe/session')
//
//     const clientSecret = await response.data.stripeClientSecret
//
//     loadingStripe.set(false)
//     stripeLoaded.set(true)
//
//     if (stripeCheckout) {
//         stripeCheckout.destroy();
//     }
//
//     stripeCheckout = await stripe.initEmbeddedCheckout({
//         clientSecret,
//     });
//
//     stripeCheckout.mount('#stripeCheckout');
// };
