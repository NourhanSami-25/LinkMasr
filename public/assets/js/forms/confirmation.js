// Cancel Confirmation
var showCancelConfirmation = function (previousUrl) {
    var modalId = "cancelConfirmationModal";
    var existingModal = document.getElementById(modalId);
    if (existingModal) {
        existingModal.remove(); // Remove existing modal to prevent duplicates
    }

    var modal = `<div id="${modalId}" class="modal fade" tabindex="-1" aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header flex-stack">
                    <h2 class="w-100 text-center">${i18n.leaveTitle}</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body pb-15">
                    <div data-kt-element="options">
                        <p class="text-muted fs-5 fw-semibold w-100 text-center mb-10">${i18n.leaveMessage}</p>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger w-100" onclick="closePage('${previousUrl}');" data-bs-dismiss="modal">${i18n.leaveButton}</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">${i18n.stayButton}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML("beforeend", modal);

    var confirmationModal = new bootstrap.Modal(
        document.getElementById(modalId)
    );
    confirmationModal.show();
};

// Function to navigate to the previous page
var closePage = function (previousUrl) {
    window.location.href = previousUrl; // Go back to the previous page
};

// Delete Confirmation
var showConfirmation = function (item, itemId) {
    var modalId = "confirmationModal";
    var existingModal = document.getElementById(modalId);
    if (existingModal) {
        existingModal.remove(); // Remove existing modal to prevent duplicates
    }

    var modal = `<div id="${modalId}" class="modal fade" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header flex-stack">
                    <h2 class="w-100 text-center">${i18n.deleteTitle}</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body pb-15">
                    <div data-kt-element="options">
                        <p class="text-gray-800 fs-5 fw-bold w-100 text-center mb-10">${i18n.deleteMessage}</p>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger w-100" onclick="deleteItem('${itemId}');" data-bs-dismiss="modal">${i18n.deleteButton}</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">${i18n.cancelButton}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML("beforeend", modal);

    var confirmationModal = new bootstrap.Modal(
        document.getElementById(modalId)
    );
    confirmationModal.show();
};

var deleteItem = function (itemId) {
    var deleteForm = document.getElementById("delete-form-" + itemId);
    deleteForm.submit();
};
