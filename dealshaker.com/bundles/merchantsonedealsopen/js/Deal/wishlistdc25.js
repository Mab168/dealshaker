var Store = Store || {};

Store.Deal = Store.Deal || {};
Store.Deal.Wishlist = (function () {
    function init(url, errorMessage) {

        var loader = '<i class="fa fa-circle-o-notch fa-spin fa-fw margin-bottom"></i>';

        function toggle(id) {
            return $.ajax({
                method: "POST",
                url: url,
                data: {
                    "deal": id
                }
            });
        }

        $("[data-wishlist-toggle]").on("click", function () {
            var btn = $(this);
            var text = btn.find("[data-wishlist-text]");
            var dealId = $(this).data("wishlist-toggle");

            btn.prop("disabled", true);
            var originalText = text.html();
            text.html(loader);


            toggle(dealId)
                .always(function () {
                    btn.prop("disabled", false);
                })
                .done(function (response) {
                    if (response.message) {
                        toastr.success(response.message);
                    }
                    text.text(response.btn_text);
                }).fail(function (response) {
                text.html(originalText);
                toastr.error(errorMessage, '', {
                        "closeButton": true,
                        "progressBar": true
                    }
                );
            });
        });

        $("[data-wishlist-remove]").on("click", function () {
            var deal = $(this).data("wishlist-remove");

            toggle(deal)
                .done(function (response) {
                    $("[data-wishlist-deal='" + deal + "'").fadeOut("normal", function () {
                        $(this).remove();

                        var size = $("[data-wishlist-deal]").length

                        $("[data-wishlist-count]").text(size);
                        if (size < 1) {
                            $('[data-empty-message="wishlist"]').removeClass('hide');
                        } else {
                            $('[data-empty-message="wishlist"]').addClass('hide');
                        }
                    });
                }).fail(function (response) {
                toastr.error(errorMessage, '', {
                        "closeButton": true,
                        "progressBar": true
                    }
                );
            });
        });
    }

    return {
        init: init
    }
})();
