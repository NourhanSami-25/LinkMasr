"use strict";

// Class definition
var KTAppInvoicesCreate = function () {
	var form;

	// Private functions
	var updateTotal = function () {

		var items = [].slice.call(form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]'));
		var invoiveTax = document.querySelector('[data-kt-element="invoice-tax"]');
		var total = 0;
		var grandTotal = 0;

		var discountType = document.querySelector('[data-kt-element="discount-type"]'); // before tax , after tax
		var discountAmount = document.querySelector('[data-kt-element="discount-amount"]'); // percentage , fixed
		var invoicePercentageDiscount = document.querySelector('[data-kt-element="invoice-discount"]'); // percentage value
		var invoiveFixedDiscount = document.querySelector('[data-kt-element="invoice-fixed-discount"]'); // fixed value
		// ##########################
		var format = wNumb({
			//prefix: '$ ',
			decimals: 2,
			thousand: ''
		});

		items.map(function (item) {

			var quantity = item.querySelector('[data-kt-element="quantity"]');
			var tax = item.querySelector('[data-kt-element="tax"]');
			var price = item.querySelector('[data-kt-element="price"]');
			var subtotalInput = item.querySelector('[data-kt-element="subtotal-input"]'); // Hidden input for submission
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
			subtotalInput.value = subtotal.toFixed(2);

			item.querySelector('[data-kt-element="item-total"]').innerText = format.to(priceValue * quantityValue + taxAmount);

			grandTotal += priceValue * quantityValue + taxAmount;
			total = grandTotal;
		});


		// Calculate over all invoice Discount & Tax
		var invoivePercentageDiscountValue = parseInt(invoicePercentageDiscount.value); // percentage value
		var invoiveFixedDiscountValue = parseInt(invoiveFixedDiscount.value); // fixed value
		var invoiveDiscountValue = 0;
		var invoiveTaxValue = parseInt(invoiveTax.value);

		invoivePercentageDiscountValue = (!invoivePercentageDiscountValue || invoivePercentageDiscountValue < 0) ? 0 : invoivePercentageDiscountValue;
		invoiveFixedDiscountValue = (!invoiveFixedDiscountValue || invoiveFixedDiscountValue < 0) ? 0 : invoiveFixedDiscountValue;
		invoiveTaxValue = (!invoiveTaxValue || invoiveTaxValue < 0) ? 0 : invoiveTaxValue;

		if (discountType.value === 'after_tax' && discountAmount.value === 'percentage') {
			// console.log('Case 1: After Tax + Percentage Discount');
			invoiveTaxValue = (invoiveTaxValue / 100) * grandTotal;
			invoivePercentageDiscountValue = (invoivePercentageDiscountValue / 100) * (grandTotal + invoiveTaxValue);
			invoiveDiscountValue = invoivePercentageDiscountValue;
			invoiveFixedDiscountValue = 0;

		}
		else if (discountType.value === 'after_tax' && discountAmount.value === 'fixed_amount') {
			// console.log('Case 2: After Tax + Fixed Amount Discount');
			invoiveTaxValue = (invoiveTaxValue / 100) * grandTotal;
			invoiveDiscountValue = invoiveFixedDiscountValue;
			invoivePercentageDiscountValue = 0;
		}
		else if (discountType.value === 'before_tax' && discountAmount.value === 'percentage') {
			// console.log('Case 3: Before Tax + Percentage Discount');

			invoivePercentageDiscountValue = (invoivePercentageDiscountValue / 100) * (grandTotal);
			invoiveDiscountValue = invoivePercentageDiscountValue;
			invoiveFixedDiscountValue = 0;
			invoiveTaxValue = (invoiveTaxValue / 100) * (grandTotal - invoiveDiscountValue);
		}
		else if (discountType.value === 'before_tax' && discountAmount.value === 'fixed_amount') {
			// console.log('Case 4: Before Tax + Fixed Amount Discount');
			invoiveDiscountValue = invoiveFixedDiscountValue;
			invoivePercentageDiscountValue = 0;
			invoiveTaxValue = (invoiveTaxValue / 100) * (grandTotal - invoiveDiscountValue);
		}
		else {
			console.log('Unknown case'); // Optional fallback for unexpected values
		}

		// Calculate grand total after tax and discount
		grandTotal += invoiveTaxValue - invoiveDiscountValue;
		if (grandTotal < 0) {
			grandTotal = 0;
		}

		form.querySelector('[data-kt-element="invoice-tax-field"]').innerText = format.to(invoiveTaxValue);
		form.querySelector('[data-kt-element="invoice-discount-field"]').innerText = format.to(invoivePercentageDiscountValue);
		form.querySelector('[data-kt-element="invoice-fixed-discount-field"]').innerText = format.to(invoiveFixedDiscountValue);
		form.querySelector('[data-kt-element="sub-total"]').innerText = format.to(total);
		form.querySelector('[data-kt-element="grand-total"]').innerText = format.to(grandTotal);
		form.querySelector('[data-kt-element="grand-total-hidden-input"]').value = format.to(grandTotal);
	}

	var handleEmptyState = function () {
		if (form.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]').length === 0) {
			var item = form.querySelector('[data-kt-element="empty-template"] tr').cloneNode(true);
			form.querySelector('[data-kt-element="items"] tbody').appendChild(item);
		} else {
			KTUtil.remove(form.querySelector('[data-kt-element="items"] [data-kt-element="empty"]'));
		}
	}

	var handeForm = function (element) {
		var itemIndex = form.querySelectorAll('[data-kt-element="items"] tbody tr').length;
		// Add item
		form.querySelector('[data-kt-element="items"] [data-kt-element="add-item"]').addEventListener('click', function (e) {
			e.preventDefault();

			var item = form.querySelector('[data-kt-element="item-template"] tr').cloneNode(true);

			// Update the name attributes for each input in the cloned item
			item.querySelectorAll('input').forEach(function (input) {
				var name = input.getAttribute('name');

				if (name) {
					// Replace the index in the name attribute with the current itemIndex
					var updatedName = name.replace(/\[x\]/, '[' + itemIndex + ']');
					input.setAttribute('name', updatedName);
				}
			});

			form.querySelector('[data-kt-element="items"] tbody').appendChild(item);

			itemIndex++;

			handleEmptyState();
			updateTotal();
		});

		// Remove item
		KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="remove-item"]', 'click', function (e) {
			e.preventDefault();

			KTUtil.remove(this.closest('[data-kt-element="item"]'));

			handleEmptyState();
			updateTotal();
		});

		// Handle price and quantity changes
		KTUtil.on(form, '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="tax"],[data-kt-element="items"] [data-kt-element="price"], [data-kt-element="items"] [data-kt-element="invoice-tax"] , [data-kt-element="items"] [data-kt-element="invoice-discount"] , [data-kt-element="discount-type"] , [data-kt-element="items"] [data-kt-element="invoice-fixed-discount"]', 'change', function (e) {
			e.preventDefault();

			updateTotal();
		});

		$(document).ready(function () {
			$('[data-kt-element="discount-type"]').select2({
				minimumResultsForSearch: Infinity // Disable search as you set 'data-hide-search=true'
			});

			// Listen for the change event on the Select2 element
			$('[data-kt-element="discount-type"]').on('change', function (e) {
				e.preventDefault();

				// Call your updateTotal function to handle the change
				updateTotal();
			});

			$('[data-kt-element="discount-amount"]').on('change', function (e) {
				e.preventDefault();
				updateTotal();
			});
		});
	}

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

			handeForm();
			initForm();
			updateTotal();
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

			// Handle address
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
			// Handle currency
			if (selectedClient.currency) {
				clientCurrencySelect.val(selectedClient.currency).trigger('change');
			}

		} else {
			clientAddress.value = '';
			clientCurrencySelect.val('').trigger('change');
		}
	});
});
