"use strict";

// Class definition
var KTAppInvoicesCreate = function () {
    var form;

    var initForm = function (element) {
        // Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
        var invoiceDate = $(form.querySelector('[name="date"]'));
        invoiceDate.flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        });

        // Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
        var dueDate = $(form.querySelector('[name="due_date"]'));
        dueDate.flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        });
    }

    // Public methods
    return {
        init: function (element) {
            form = document.querySelector('#kt_invoice_form');

            initForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppInvoicesCreate.init();
});

// Script to show client address when select the client
document.addEventListener('DOMContentLoaded', function () {
    // Use clientsData from the global scope (passed from Blade)
    const clients = clientsData;
    const clientSelect = $('#clientSelect');
    const clientAddress = document.getElementById('clientAddress');
    const clientCurrencySelect = $('#clientCurrency');

    // Populate the select dropdown with client options
    // clients.forEach(client => {
    //     const option = new Option(client.name, client.id);
    //     clientSelect.append(option);
    // });

    // Initialize select2 for the client dropdown
    clientSelect.select2();

    // Handle client selection and update address
    clientSelect.on('select2:select', function (e) {
        const selectedClient = clients.find(client => client.id == e.params.data.id);
        if (selectedClient) {
            if (selectedClient.address) {
                const addressComponents = [
                    selectedClient.address.street_name,
                    selectedClient.address.city,
                    selectedClient.address.state,
                    selectedClient.address.country
                ];
                const filteredComponents = addressComponents.filter(component => component); // Filter out empty/null components
                const fullAddress = filteredComponents.join(' - '); // Join components with a separator
                clientAddress.value = fullAddress;
            } else {
                clientAddress.value = '-----'; // Fallback message for no address
            }

            if (selectedClient.currency) {
				clientCurrencySelect.val(selectedClient.currency).trigger('change');
			}

        } else {
            clientAddress.value = '';
        }
    });

});
