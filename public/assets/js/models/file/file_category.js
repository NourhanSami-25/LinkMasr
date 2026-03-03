document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('kt_modal_new_target_upload_file');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const category = button.getAttribute('data-category');

        // Example: populate a hidden input inside modal
        const input = modal.querySelector('input[name="category"]');
        if (input) {
            input.value = category;
        }

        // Or update some content in modal
        const displayArea = modal.querySelector('.modal-category-display');
        if (displayArea) {
            displayArea.textContent = category;
        }
    });
});
