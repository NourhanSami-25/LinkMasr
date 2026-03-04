"use strict";

// Class definition
var KTAppExpenseCreate = function () {
	var form;

	// Private functions
	var updateTotal = function () {
		var items = [].slice.call(form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]'));
		var total = 0;
		var grandTotal = 0;

		var format = wNumb({
			decimals: 2,
			thousand: ''
		});

		items.map(function (item) {
			var quantity = item.querySelector('[data-kt-element="quantity"]');
			var tax = item.querySelector('[data-kt-element="tax"]');
			var price = item.querySelector('[data-kt-element="price"]');
			var subtotalInput = item.querySelector('[data-kt-element="subtotal-input"]');
			var taxAmount;

			var priceValue = format.from(price.value);
			priceValue = (!priceValue || priceValue < 0) ? 0 : priceValue;

			var quantityValue = parseInt(quantity.value);
			quantityValue = (!quantityValue || quantityValue < 0) ? 1 : quantityValue;

			var taxValue = parseInt(tax.value);
			taxValue = (!taxValue || taxValue < 0) ? 0 : taxValue;

			price.value = format.to(priceValue);
			quantity.value = quantityValue;
			tax.value = taxValue;

			taxAmount = (taxValue / 100) * priceValue * quantityValue;
			var subtotal = priceValue * quantityValue + taxAmount;
			
			if (subtotalInput) {
				subtotalInput.value = subtotal.toFixed(2);
			}

			var totalElement = item.querySelector('[data-kt-element="total"]');
			if (totalElement) {
				totalElement.innerText = format.to(subtotal);
			}

			grandTotal += subtotal;
			total = grandTotal;
		});

		// Update totals
		var subTotalElement = form.querySelector('[data-kt-element="sub-total"]');
		var grandTotalElement = form.querySelector('[data-kt-element="grand-total"]');
		var grandTotalHiddenInput = form.querySelector('[data-kt-element="grand-total-hidden-input"]');

		if (subTotalElement) {
			subTotalElement.innerText = format.to(total);
		}
		if (grandTotalElement) {
			grandTotalElement.innerText = format.to(grandTotal);
		}
		if (grandTotalHiddenInput) {
			grandTotalHiddenInput.value = format.to(grandTotal);
		}
	}

	var handleEmptyState = function () {
		if (form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]').length === 0) {
			var item = form.querySelector('[data-kt-element="empty-template"] tr').cloneNode(true);
			form.querySelector('[data-kt-element="items"] tbody').appendChild(item);
		} else {
			KTUtil.remove(form.querySelector('[data-kt-element="items"] [data-kt-element="empty"]'));
		}
	}

	var handleForm = function () {
		var itemIndex = form.querySelectorAll('[data-kt-element="items"] tbody tr').length;
		
		// Add item
		var addButton = form.querySelector('[data-kt-element="items"] [data-kt-element="add-item"]');
		if (addButton) {
			addButton.addEventListener('click', function (e) {
				e.preventDefault();

				var template = document.querySelector('[data-kt-element="item-template"] tr');
				if (!template) {
					console.error('Item template not found');
					return;
				}
				var item = template.cloneNode(true);

				// Update the name attributes for each input in the cloned item
				item.querySelectorAll('input, select, textarea').forEach(function (input) {
					var name = input.getAttribute('name');
					if (name) {
						var updatedName = name.replace(/\[x\]/, '[' + itemIndex + ']');
						input.setAttribute('name', updatedName);
					}
				});

				form.querySelector('[data-kt-element="items"] tbody').appendChild(item);
				itemIndex++;

				handleEmptyState();
				updateTotal();
			});
		}

		// Remove item
		KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="remove-item"]', 'click', function (e) {
			e.preventDefault();
			KTUtil.remove(this.closest('[data-kt-element="item"]'));
			handleEmptyState();
			updateTotal();
		});

		// Handle price and quantity changes
		KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="tax"], [data-kt-element="items"] [data-kt-element="price"]', 'change', function (e) {
			e.preventDefault();
			updateTotal();
		});
	}

	var initForm = function () {
		// Date picker
		var invoiceDate = $(form.querySelector('[name="date"]'));
		if (invoiceDate.length) {
			invoiceDate.flatpickr({
				enableTime: false,
				dateFormat: "Y-m-d",
			});
		}
	}

	// Public methods
	return {
		init: function () {
			form = document.querySelector('#kt_invoice_form');
			if (form) {
				handleForm();
				initForm();
				updateTotal();
			}
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTAppExpenseCreate.init();
});

// Script to show client address when select the client
document.addEventListener('DOMContentLoaded', function () {
	const clients = clientsData || [];
	const addresses = clientAddressesData || {};
	const clientSelect = $('#clientSelect');
	const clientAddress = document.getElementById('clientAddress');
	const clientCurrencySelect = $('#clientCurrency');

	if (clientSelect.length) {
		// Initialize select2 for the client dropdown
		clientSelect.select2();

		// Handle client selection and update address
		clientSelect.on('select2:select', function (e) {
			const selectedClient = clients.find(client => client.id == e.params.data.id);
			if (selectedClient) {
				// Handle address
				const clientAddressData = addresses[selectedClient.id];
				if (clientAddressData) {
					const addressComponents = [
						clientAddressData.street_name,
						clientAddressData.city,
						clientAddressData.state,
						clientAddressData.country
					];
					const filteredComponents = addressComponents.filter(component => component);
					const fullAddress = filteredComponents.join(' - ');
					if (clientAddress) {
						clientAddress.value = fullAddress;
					}
				} else {
					if (clientAddress) {
						clientAddress.value = '-----';
					}
				}
				
				// Handle currency
				if (selectedClient.currency && clientCurrencySelect.length) {
					clientCurrencySelect.val(selectedClient.currency).trigger('change');
				}
			} else {
				if (clientAddress) {
					clientAddress.value = '';
				}
				if (clientCurrencySelect.length) {
					clientCurrencySelect.val('').trigger('change');
				}
			}
		});
	}
});