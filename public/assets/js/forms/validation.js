document.addEventListener("DOMContentLoaded", function () {

    // Inject CSS styles dynamically
    const style = document.createElement("style");
    style.innerHTML = `
         .select2-container--default .select2-selection--single {
            border-color: #e3342f !important;
        }
        .input-error {
            color: rgb(218, 41, 35) !important;
            font-size: 13px;
            font-weight: bold;
        }
    `;
    document.head.appendChild(style); // Add styles to the document head

    function initFormValidation() {
        const forms = document.querySelectorAll("form"); // Select all forms

        forms.forEach(form => {
            form.addEventListener("submit", function (e) {
                let isValid = true; // Track if the form is valid

                const inputs = form.querySelectorAll("[data-required='true'], [data-minlength], [data-maxlength], [data-type]");
                let dateField, dueDateField;

                inputs.forEach(input => {

                    let hasError = false; // Track individual input validity
                    const maxLength = input.getAttribute("data-maxlength");
                    const minLength = input.getAttribute("data-minlength");
                    const dataType = input.getAttribute("data-type");
                    const errorElement = document.createElement("div");
                    errorElement.classList.add("input-error");

                    // Remove any previous error message
                    const existingError = input.nextElementSibling;
                    if (existingError && existingError.classList.contains("input-error")) {
                        existingError.remove();
                    }

                    // Handle select2 elements separately
                    if (input.tagName.toLowerCase() === "select" && input.classList.contains("form-select")) {
                        const select2Container = input.closest(".select2-container") || input.nextElementSibling;

                        if (!input.value.trim()) {
                            e.preventDefault(); // Prevent form submission
                            isValid = false; // Mark form as invalid

                            // errorElement.textContent = "This field is required";
                            const fieldLabel = input.getAttribute("data-label") || input.placeholder || input.name;
                            // errorElement.textContent = `${fieldLabel} is required`;
                            errorElement.textContent = `${window.translations.field} ${fieldLabel} ${window.translations.is_required}`;

                            // Remove previous error message for select2
                            const existingSelect2Error = select2Container.parentElement.querySelector(".input-error");
                            if (existingSelect2Error) {
                                existingSelect2Error.remove(); // Remove existing select2 error
                            }

                            // Style the select2 dropdown and show error
                            if (select2Container) {
                                select2Container.parentElement.appendChild(errorElement); // Append error message
                            }
                        } else {
                            // Remove error if valid
                            if (select2Container) {
                                // Remove the error message div for select2
                                const selectError = select2Container.parentElement.querySelector(".input-error");
                                if (selectError) {
                                    selectError.remove(); // Remove the error message div
                                }
                            }

                        }
                    } else if (input.type === "file") {
                        // **File validation**:
                        const maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
                        const allowedExtensions = ["doc", "docx", "xls", "xlsx", "pdf", "ppt", "pptx", "rar", "zip", "jpg", "jpeg", "png", "gif"];

                        if (input.files.length > 0) {
                            const file = input.files[0];
                            const fileSize = file.size;
                            const fileExtension = file.name.split('.').pop().toLowerCase();

                            if (fileSize > maxFileSize) {
                                e.preventDefault();
                                isValid = false;
                                hasError = true;
                                errorElement.textContent = "File size must be 5 MB or less";
                                input.after(errorElement);
                            } else if (!allowedExtensions.includes(fileExtension)) {
                                e.preventDefault();
                                isValid = false;
                                hasError = true;
                                errorElement.textContent = `Allowed file types: ${allowedExtensions.join(", ")}`;
                                input.after(errorElement);
                            }
                        } else if (input.hasAttribute("data-required") && input.files.length === 0) {
                            e.preventDefault();
                            isValid = false;
                            hasError = true;
                            errorElement.textContent = "Please upload a file";
                            input.after(errorElement);
                        }
                    } else {

                        // 1. **Required validation**:
                        if (input.hasAttribute("data-required") && !input.value.trim()) {
                            e.preventDefault();
                            isValid = false;
                            hasError = true;
                            // errorElement.textContent = "This field is required";
                            const fieldLabel = input.getAttribute("data-label") || input.placeholder || input.name;
                            // errorElement.textContent = `${fieldLabel} is required`;

                            errorElement.textContent = `${window.translations.field} ${fieldLabel} ${window.translations.is_required}`;
                            input.after(errorElement);
                        } else {
                            input.classList.remove("input-error");
                        }

                    }

                    // 2. **Maxlength validation** (only if required validation passes):
                    if (!hasError && maxLength && input.value.trim() !== '' && input.value.length > maxLength) {
                        e.preventDefault();
                        isValid = false;
                        errorElement.textContent = `This field cannot exceed ${maxLength} characters`;
                        input.after(errorElement);
                    } else if (!hasError) {
                        input.classList.remove("input-error");
                    }
                    

                    // 3. **Minlength validation** (only if required validation passes):
                    if (!hasError && minLength && input.value.trim() !== '' && input.value.length < minLength) {
                        e.preventDefault();
                        isValid = false;
                        errorElement.textContent = `This field must be greater than ${minLength} characters`;
                        input.after(errorElement);
                    } else if (!hasError) {
                        input.classList.remove("input-error");
                    }

                    // 4. **Data Type Validation** (only if required validation passes):
                    if (!hasError && dataType && input.value.trim() !== '') {
                        if (dataType === "number" && isNaN(input.value)) {
                            e.preventDefault();
                            isValid = false;
                            errorElement.textContent = "Please enter a valid number";
                            input.after(errorElement);
                        } else if (dataType === "text" && /\d/.test(input.value)) {
                            e.preventDefault();
                            isValid = false;
                            errorElement.textContent = "Text cannot contain numbers";
                            input.after(errorElement);
                        } else if (dataType === "email") {
                            const email = input.value.trim();
                            const emailRegex = /^\S+@\S+\.\S+$/;

                            if (!emailRegex.test(email)) {
                                e.preventDefault();
                                isValid = false;
                                errorElement.textContent = "Please enter a valid email address";
                                input.after(errorElement);
                            } else if (existingEmails.includes(email.toLowerCase())) {
                                e.preventDefault();
                                isValid = false;
                                errorElement.textContent = "This email is already taken";
                                input.after(errorElement);
                            }
                        } else if (
                            dataType === "date" &&
                            input.value.trim() !== "" &&
                            !/^\d{4}-\d{2}-\d{2}$/.test(input.value)
                        ) {
                            e.preventDefault();
                            isValid = false;
                            errorElement.textContent = "Please enter a valid date (YYYY-MM-DD)";
                            input.after(errorElement);
                        } else if (
                            dataType === "dateTime" &&
                            input.value.trim() !== "" &&
                            !/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(input.value)
                        ) {
                            e.preventDefault();
                            isValid = false;
                            errorElement.textContent = "Please enter a valid date and time (YYYY-MM-DD HH:mm)";
                            input.after(errorElement);
                        } else if (
                            dataType === "time" &&
                            input.value.trim() !== "" &&
                            !/^\d{2}:\d{2}$/.test(input.value)
                        ) {
                            e.preventDefault();
                            isValid = false;
                            errorElement.textContent = "Please enter a valid time (HH:mm)";
                            input.after(errorElement);
                        }
                        else {
                            input.classList.remove("is-invalid");
                        }
                    }

                    // 5. **Date Validation** Validate if date after due_date (only if required validation passes):
                    // Track date and due_date fields

                    if (input.name === "date") {
                        dateField = input;

                    } else if (input.name === "due_date") {
                        dueDateField = input;
                    }

                });

                // Only validate date vs. due_date once after all inputs processed
                if (dateField && dueDateField) {
                    const dateValue = new Date(dateField.value);
                    const dueDateValue = new Date(dueDateField.value);

                    if (dateField.value && dueDateField.value && dueDateValue < dateValue) {
                        e.preventDefault();
                        isValid = false;

                        const errorElement = document.createElement("div");
                        errorElement.classList.add("input-error");
                        errorElement.textContent = `${window.translations.due_date_error}`;

                        // Remove existing error if any
                        const existingError = dueDateField.nextElementSibling;
                        if (!existingError || !existingError.classList.contains("input-error")) {
                            dueDateField.after(errorElement);
                        }
                    }
                }


                

                

                // Collect all error messages
                const errorMessages = document.querySelectorAll(".input-error");
                let errorSummary = [];

                errorMessages.forEach(error => {
                    if (error.textContent.trim()) {
                        errorSummary.push(error.textContent.trim());
                    }
                });

                // 2. Add balance warning if visible
                const balanceWarning = document.getElementById("balance-warning");
                if (balanceWarning && balanceWarning.style.display !== "none") {
                    errorSummary.push(balanceWarning.textContent.trim());
                     e.preventDefault();
                     isValid = false;
                }


                // Inject error summary into a hidden input or visible container
                let summaryContainer = document.querySelector("#form-error-summary");
                if (summaryContainer) {
                    const ul = summaryContainer.querySelector("ul") || document.createElement("ul");
                    ul.innerHTML = ""; // Clear old messages
                    ul.classList.add("mb-0", "mt-2", "ps-4");

                    if (errorSummary.length > 0) {
                        summaryContainer.style.display = "block";
                        errorSummary.forEach(msg => {
                            const li = document.createElement("li");
                            li.textContent = msg;
                            ul.appendChild(li);
                        });
                        summaryContainer.appendChild(ul);
                    } else {
                        summaryContainer.style.display = "none";
                    }
                }

                if (isValid) {
                    form.submit();
                }
            });
        });
    }

    initFormValidation();
});
