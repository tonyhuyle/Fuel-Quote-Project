function calculatePrice(gallons, state, hasHistory) {
    const currentPrice = 1.50;
    const locationFactor = state === 'TX' ? 0.02 : 0.04;
    const rateHistoryFactor = !hasHistory ? 0 : 0.01;
    const gallonsRequestedFactor = gallons > 1000 ? 0.02 : 0.03;
    const companyProfitFactor = 0.10;

    const margin = currentPrice * (locationFactor - rateHistoryFactor + gallonsRequestedFactor + companyProfitFactor);
    const suggestedPrice = currentPrice + margin;
    const totalAmountDue = gallons * suggestedPrice;

    return { suggestedPrice, totalAmountDue };
}

function getQuote() {
    const gallons = document.getElementById('gallons').value;
    const state = document.getElementById('state').value;
    const hasHistory = document.getElementById('hasHistory').value;

    const { suggestedPrice, totalAmountDue } = calculatePrice(gallons, state, hasHistory);

    document.getElementById('suggestedPrice').value = suggestedPrice.toFixed(3);
    document.getElementById('totalPrice').value = totalAmountDue.toFixed(3);

    document.getElementById('submitQuote').disabled = false;
}

// Enable/Disable buttons based on form input
window.onload = function() {
    const form = document.getElementById('quoteForm');
    const getQuoteButton = document.getElementById('getQuote');
    const submitQuoteButton = document.getElementById('submitQuote');

    getQuoteButton.addEventListener('click', getQuote);

    function checkForm() {
        let getQuoteEnabled = true;
        let submitQuoteEnabled = true;
        form.querySelectorAll('input').forEach(input => {
            if (!input.value && input.required) {
                getQuoteEnabled = false;
            }
            if (!input.value && input.readOnly) {
                submitQuoteEnabled = false;
            }
        });
        getQuoteButton.disabled = !getQuoteEnabled;
        submitQuoteButton.disabled = !submitQuoteEnabled;
    }
    
    form.addEventListener('input', checkForm);
    checkForm();
}
