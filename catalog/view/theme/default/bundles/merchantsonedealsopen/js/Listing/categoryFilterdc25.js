var Store = Store || {};

Store.Listing = Store.Listing || {};
Store.Listing.categoryFilter = (function () {

    function initUiSlider() {

        $('[data-price-slider="price-eur"]').each(function () {
            var priceSlider = $(this)[0],
                eurPriceSlider = $(this),
                startMin = eurPriceSlider.data('price-start-min'),
                startMax = eurPriceSlider.data('price-start-max');
                
            noUiSlider.create(priceSlider, {
                start: [$('[data-min-price-eur]').data('min-price-eur'), $('[data-max-price-eur]').data('max-price-eur')],
                connect: true,
                range: {
                    'min': startMin,
                    'max': startMax
                }

            });
            priceSlider.noUiSlider.on('update', function (values, handle) {
                var value = values[handle];
                if (handle) {
                    eurPriceSlider.parents('.slide-item').find('[data-max-price]').text(Math.round(value));
                } else {
                    eurPriceSlider.parents('.slide-item').find('[data-min-price]').text(Math.round(value));
                }
            });
            priceSlider.noUiSlider.on('set', function (values, handle) {
                var value = values[handle];
                if (handle) {
                    eurPriceSlider.parents('.slide-item').find('[data-max-price]').text(Math.round(value));
                    window.history.pushState("", window.title, addQueryString('deal_max_price_eur', Math.round(value)));
                } else {
                    eurPriceSlider.parents('.slide-item').find('[data-min-price]').text(Math.round(value));
                    window.history.pushState("", window.title, addQueryString('deal_min_price_eur', Math.round(value)));
                }
                getResults();
            });
        });


        $('[data-price-slider="price-one"]').each(function () {
            var priceSlider = $(this)[0],
                onePriceSlider = $(this),
                startMin = onePriceSlider.data('price-start-min'),
                startMax = onePriceSlider.data('price-start-max');


            noUiSlider.create(priceSlider, {
                start: [$('[data-min-price-one]').data('min-price-one'), $('[data-max-price-one]').data('max-price-one')],
                connect: true,
                range: {
                    'min': startMin,
                    'max': startMax
                }
            });
            priceSlider.noUiSlider.on('update', function (values, handle) {
                var value = values[handle];
                if (handle) {
                    onePriceSlider.parents('.slide-item').find('[data-max-price]').text(Math.round(value));
                } else {
                    onePriceSlider.parents('.slide-item').find('[data-min-price]').text(Math.round(value));
                }
            });

            priceSlider.noUiSlider.on('set', function (values, handle) {
                var value = values[handle];
                if (handle) {
                    onePriceSlider.parents('.slide-item').find('[data-max-price]').text(Math.round(value));
                    window.history.pushState("", window.title, addQueryString('deal_max_price_one', Math.round(value)));
                } else {
                    onePriceSlider.parents('.slide-item').find('[data-min-price]').text(Math.round(value));
                    window.history.pushState("", window.title, addQueryString('deal_min_price_one', Math.round(value)));
                }
                getResults();
            });
        });
    }

    function addQueryString(key, value, url) {
        if (!url) url = window.location.href;
        var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
            hash;

        if (re.test(url)) {
            if (typeof value !== 'undefined' && value !== null) {
                return url.replace(re, '$1' + key + "=" + value + '$2$3');

            } else {
                hash = url.split('#');
                url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
            }
        } else {
            if (typeof value !== 'undefined' && value !== null) {
                var separator = url.indexOf('?') !== -1 ? '&' : '?';
                hash = url.split('#');
                url = hash[0] + separator + key + '=' + value;
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
            }
        }

        if ($('[data-value="' + value + '"]').next().text() !== '') {
            $('#active-filters').append(
                '<li>' +
                $('[data-value="' + value + '"]').next().text() +
                '<span class="remove-filter" data-active-filter="' + value + '" title="">' +
                '<i class="fa fa-remove pull-right"></i>' +
                '</span>' +
                '</li>'
            );
        }
        if ($('#active-filters-title').hasClass('hidden')) {
            $('#active-filters-title').removeClass('hidden');

        }
        return url;
    }

    function removeQueryString(key, value, url) {
        $('[data-active-filter="' + value + '"]').parent().remove();
        if ($('[data-active-filter]').length === 0) {
            $('#active-filters-title').addClass('hidden');

        }
        if (!url) url = window.location.href;
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {
            var queryStringToRemove = key + '=' + value;
            var partsToKeep = [];
            var queryStrings = urlparts[1].split('&');
            for (var i = 0, l = queryStrings.length; i < l; i++) {
                if (queryStrings[i] != queryStringToRemove) {
                    partsToKeep.push(queryStrings[i])
                }
            }
            if (partsToKeep.length === 0) {
                return urlparts[0];
            }
            url = urlparts[0] + '?' + partsToKeep.join('&');
            return url;
        } else {
            return url;
        }
    }

    function getQueryStringValue(key) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        var arrayResult = [];
        var pair = null;
        for (var i = 0; i < vars.length; i++) {
            pair = vars[i].split("=");
            if (pair[0] == key && key.indexOf('[]') === -1) {
                return pair[1].trim();
            } else if (pair[0] == key && key.indexOf('[]') !== -1) {

                arrayResult.push(String(pair[1]));
            }
        }
        if (arrayResult.length !== 0) {
            return arrayResult;
        }
        return '';
    }

    $(document).on('click', '[data-active-filter]', function () {
        $(this).parent().remove();
        var filterElement = $('[data-value="' + $(this).data('active-filter') + '"]');
        filterElement.prop('checked', false);
        console.log(filterElement.data('filter'), filterElement.data('value'))
        window.history.pushState("", window.title, removeQueryString(filterElement.data('filter'), filterElement.data('value')));
        getResults();
    });

    $('[data-filter="deal_delivery_method[]"]').change(function () {
        if ($(this).prop('checked') === true) {
            window.history.pushState("", window.title, addQueryString('deal_delivery_method[]', $(this).data('value')));
        } else {
            window.history.pushState("", window.title, removeQueryString('deal_delivery_method[]', $(this).data('value')));
        }
        getResults();
    });
    $('[data-filter="deal_business_type[]"]').change(function () {
        if ($(this).prop('checked') === true) {
            window.history.pushState("", window.title, addQueryString('deal_business_type[]', $(this).data('value')));
        } else {
            window.history.pushState("", window.title, removeQueryString('deal_business_type[]', $(this).data('value')));
        }
        getResults();
    });

    function getResults() {
        var page = getQueryStringValue('page') == '' ? 1 : getQueryStringValue('page');
        var request = {
            sort_order: getQueryStringValue('sort_order'),
            deal_min_price_gdg: getQueryStringValue('deal_min_price_eur'),
            deal_max_price_gdg: getQueryStringValue('deal_max_price_eur'),
            deal_min_price_btc: getQueryStringValue('deal_min_price_one'),
            deal_max_price_btc: getQueryStringValue('deal_max_price_one')
        };

        $.get(
            $('[data-xhr-target]').data('xhr-target').trim(),
            request
        )
            .done(function (data) {
                if (data.trim() !== '') {
                    $('.category-list').empty().html(data);
                }
            });
    }


    $(document).on('change', '[data-filter="sort_order"]', function () {
        window.history.pushState("", window.title, addQueryString('sort_order', $(this).val()));
        getResults();
    });
    function init() {
        $(document).ready(function () {
            initUiSlider();
        });
    }

    return {
        init: init
    }

}());
