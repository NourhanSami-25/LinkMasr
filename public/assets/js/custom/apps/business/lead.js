"use strict";

// Class definition
var KTAppInvoicesCreate = (function () {
    var form;

    var initForm = function (element) {
        // Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
        var invoiceDate = $(form.querySelector('[name="date"]'));
        invoiceDate.flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        });
    };

    // Public methods
    return {
        init: function (element) {
            form = document.querySelector("#kt_invoice_form");

            initForm();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppInvoicesCreate.init();
});
