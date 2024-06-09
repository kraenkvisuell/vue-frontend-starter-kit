import numeral from 'numeral'

numeral.register('locale', 'de', {
    delimiters: {
        thousands: '.',
        decimal: ','
    },
    currency: {
        symbol: '€'
    }
});

export default {

    formatted(amount, format = 'de') {
        numeral.locale(format);
        return numeral(amount / 100).format('0,0.00');
    },

    formattedWithSign(amount, format = 'de') {
        numeral.locale(format);
        return numeral(amount / 100).format('0,0.00 $');
    },

    dollars(amount) {
        let str = numeral(amount / 100).format('0.00');
        return str.substring(0, str.indexOf('.'));
    },

    cents(amount) {
        let str = numeral(amount / 100).format('0.00');
        return str.substring(str.indexOf('.') + 1);
    }
}
