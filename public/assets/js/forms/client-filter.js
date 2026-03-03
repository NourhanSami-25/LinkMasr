$(document).ready(function () {
    const $clientSelect = $('#clientSelect');
    const $taskSelect = $('[name="task_id"]');
    const $projectSelect = $('[name="project_id"]');
    const $paymentRequestSelect = $('[name="pymentRequest_id"]');


    // Clone original options
    const originalTaskOptions = $taskSelect.find('option').clone();
    const originalProjectOptions = $projectSelect.find('option').clone();
    const originalPaymentRequestOptions = $paymentRequestSelect.find('option').clone();

    $clientSelect.on('change', function () {
        const clientId = $(this).val();
        filterOptions($taskSelect, originalTaskOptions, clientId);
        filterOptions($projectSelect, originalProjectOptions, clientId);
        filterOptions($paymentRequestSelect, originalPaymentRequestOptions, clientId);
    });

    function filterOptions($select, originalOptions, clientId) {
        const filtered = originalOptions.filter(function () {
            return !this.value || $(this).data('client-id') == clientId;
        });

        $select.empty().append(filtered).trigger('change.select2');
    }

    // ✅ Auto-trigger on page load for pre-selected client (edit mode)
    if ($clientSelect.val()) {
        $clientSelect.trigger('change');
    }
});
