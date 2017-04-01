var Store = Store || {};

Store.Deal = Store.Deal || {};
Store.Deal.Detail = (function () {

    var quantity = 1;

    function quantityChange(element, eurPriceSelector, onePriceSelector, precisionAttribute, quantityLimitSelector) {

        quantity = parseInt(element.val()), quantityLimit = $('[' + quantityLimitSelector + ']');

        if (!(typeof quantityLimit === 'undefined')) {
            var maxQuantity = quantityLimit.data(quantityLimitSelector.replace('data-', ''));
            if (quantity > maxQuantity) {
                quantity = maxQuantity;
                element.val(maxQuantity);
            }
        }
        if (quantity < 1) {
            quantity = 1;
            element.val(quantity);
        }

        var priceField = $('[' + eurPriceSelector + ']');
        var oneField = $('[' + onePriceSelector + ']');

        var cashPrecision = parseInt(priceField.attr(precisionAttribute));
        var onePrecision = parseInt(oneField.attr(precisionAttribute));

        priceField.html((parseFloat(priceField.attr(eurPriceSelector)) * quantity).toFixed(cashPrecision));
        oneField.html((parseFloat(oneField.attr(onePriceSelector)) * quantity).toFixed(onePrecision));
    }

    function init(qtySelector, eurPriceSelector, onePriceSelector, precisionAttribute, quantityLimitSelector, purchaseSelector, purchaseLink) {

        $(function () {
            $('[' + qtySelector + ']').on('change keyup paste', function () {
                quantityChange($(this), eurPriceSelector, onePriceSelector, precisionAttribute, quantityLimitSelector);
            });


            $('[' + purchaseSelector + ']').on('click', function() {
                window.location.href = purchaseLink + quantity;

                return true;
            });

            var coundownEl = $('#dealCountdown');
            var coundownDate = coundownEl.data('date-end');
            var dateNow = coundownEl.data('date-now');

            coundownEl.countdown({
                until: new Date(coundownDate),
                timezone: +3,
                serverSync: function () {
                    return new Date(dateNow);
                },
                onExpiry: function () {
                    window.reload();
                },
                layout: '<span class="label pull-right deal-countdown">{hn}:{mn}:{sn}</span>'
            });
        });
    }

    return {
        init: init
    }
})
();
