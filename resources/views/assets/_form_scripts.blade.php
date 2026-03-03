<script src="{{ asset('assets/js/forms/date-picker.js') }}"></script>	
<script src="{{ asset('assets/js/forms/validation.js') }}"></script>
<script src="{{ asset('assets/js/forms/client-filter.js') }}" defer></script>


    {{-- Attachment Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        	const fileInput = document.getElementById("attachments");
        	const fileChosen = document.getElementById("file-chosen");

        	if (fileInput && fileChosen) {
        		fileInput.addEventListener("change", function () {
        			const files = Array.from(this.files).map(file => file.name);
        			fileChosen.textContent = files.length > 0 ? files.join(", ") : "No files chosen";
        		});
        	}
        });
    </script>

    <script>
        window.translations = {
            is_required: "{{ __('general.is_required') }}",
            fix_errors: "{{ __('general.fix_errors') }}",
            field: "{{ __('general.field') }}",
            due_date_error: "{{ __('general.the_due_date_is_must_be_after_start_date') }}"
        };
    </script>

    <script>
    let isFormDirty = false;
    let pendingNavigationHref = null;

    // Build and inject modal dynamically
    const modalHtml = `
    <div id="unsavedChangesModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header flex-stack">
                    <h2 class="w-100 text-center">${i18n.leaveTitle}</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body pb-15">
                    <p class="text-muted fs-5 fw-semibold text-center mb-10">${i18n.leaveMessage}</p>
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger w-100" id="confirmLeave">${i18n.leaveButton}</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">${i18n.stayButton}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    // Add behavior
    window.addEventListener('load', function () {
        document.querySelectorAll('form input:not(.chat-input), form textarea:not(.chat-input), form select:not(.chat-input)').forEach((el) => {
            el.addEventListener('change', () => {
                isFormDirty = true;
            });
        });


        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', () => {
                isFormDirty = false;
            });
        });

        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', function (e) {
                if (isFormDirty) {
                    e.preventDefault();
                    pendingNavigationHref = this.href;
                    const modal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
                    modal.show();
                }
            });
        });

        document.getElementById('confirmLeave').addEventListener('click', function () {
            window.location.href = pendingNavigationHref;
        });
    });
    </script>
