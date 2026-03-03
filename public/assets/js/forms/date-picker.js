"use strict";
var FormDatePicker = function () {
    const handleDatePicker = () => {
        const datepickers = document.querySelectorAll('.flatpickr-date');

        datepickers.forEach((datepicker) => {
            flatpickr(datepicker, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        });
    }

    const showDatepickers = () => {
        document.querySelectorAll('.flatpickr-date').forEach(datepicker => {
            datepicker.parentNode.classList.remove('d-none');
        });
    }

    const hideDatepickers = () => {
        document.querySelectorAll('.flatpickr-date').forEach(datepicker => {
            datepicker.parentNode.classList.add('d-none');
        });
    }

    return {
        init: function () {
            handleDatePicker();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    FormDatePicker.init();
});
