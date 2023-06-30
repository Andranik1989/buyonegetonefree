define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, Component, priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'AndMage_BuyOneGetOne/checkout/summary/customfee'
            },
            isDisplayedCustomdiscount: function () {
                return true;
            },
            getCustomDiscount: function () {
                let totalItems = this.getTotals().items;
                let count = 0;
                totalItems.forEach((item) => {
                    let itemOption = JSON.parse(item.options);
                    if (typeof itemOption.productStatus != 'undefined') {
                        count += parseFloat(itemOption.productStatus.value) * parseFloat(item.qty);
                    }
                });
                if (this.custom_discount == 'Discount Percent') {
                    let originalSubtotal = this.getTotals().subtotal + count
                    let discountPercent = 100 * count / originalSubtotal
                    return Math.round(discountPercent) + '%';
                } else {
                    return priceUtils.formatPrice(count);
                }
            },
        });
    }
);
