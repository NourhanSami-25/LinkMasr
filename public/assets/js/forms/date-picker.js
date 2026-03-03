"use strict";
var FormDatePicker = function () {
    const handleDatePicker = () => {
        const datepickers = document.querySelectorAll('.flatpickr-date');

        datepickers.forEach((datepicker) => {
            const fieldName = datepicker.name || datepicker.id || '';
            const isStartDate = fieldName.includes('start') || fieldName.includes('from') || fieldName.includes('begin') || fieldName === 'date';
            const isEndDate = fieldName.includes('end') || fieldName.includes('to') || fieldName.includes('deadline') || fieldName.includes('finish') || fieldName.includes('due');
            
            let config = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            };

            // For start dates: prevent selecting past dates
            if (isStartDate) {
                config.minDate = "today";
            }

            // For end dates: set minDate based on corresponding start date
            if (isEndDate) {
                // Try to find the corresponding start date field
                let startDateField = null;
                const form = datepicker.closest('form');
                
                if (form) {
                    // Common patterns for start date field names
                    const possibleStartNames = [
                        'start_date', 'start', 'from_date', 'from', 'begin_date', 'begin', 'date'
                    ];
                    
                    for (let name of possibleStartNames) {
                        startDateField = form.querySelector(`[name="${name}"], #${name}`);
                        if (startDateField) break;
                    }
                }

                if (startDateField) {
                    // Set initial minDate if start date already has a value
                    if (startDateField.value) {
                        config.minDate = startDateField.value;
                    }

                    // Update end date minDate when start date changes
                    startDateField.addEventListener('change', function() {
                        if (this.value) {
                            const endDateInstance = datepicker._flatpickr;
                            if (endDateInstance) {
                                endDateInstance.set('minDate', this.value);
                            }
                        }
                    });
                }
            }

            flatpickr(datepicker, config);
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
