$(document).ready(function () {
    // Event listener for change on the main select
    $(".task-relation-type").on("change", function () {
        const selectedValue = $(this).val();
        const taskInput = document.getElementById("task_subject");
        const projectInput = document.getElementById("project_subject");
        const clientInput = document.getElementById("client_name");

        // Hide all secondary selects initially
        $(".secondary-selects").hide();

        // Show the specific div based on the selected value
        if (selectedValue === "task") {
            projectInput.removeAttribute("data-required");
            clientInput.removeAttribute("data-required");
            taskInput.setAttribute("data-required", "true");
            $(".select-task").show();
        } else if (selectedValue === "project") {
            taskInput.removeAttribute("data-required");
            clientInput.removeAttribute("data-required");
            projectInput.setAttribute("data-required", "true");
            $(".select-project").show();
        } else if (selectedValue === "client") {
            taskInput.removeAttribute("data-required");
            projectInput.removeAttribute("data-required");
            clientInput.setAttribute("data-required", "true");
            $(".select-client").show();
        }
    });
});

// Wait for the DOM to load before attaching event listeners
document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("start_date");
    const endDateInput = document.getElementById("end_date");
    const errorMessage = document.getElementById("date-error");
    const durationInput = document.getElementById("duration"); // This may or may not exist
    const durationTypeInput = document.getElementById("duration_type"); // This may or may not exist
    const $vacationTypeInput = $("#vacation_type");
    // vacationTypeInput?.addEventListener('change', handleVacationTypeChange);

    // Add event listeners to detect changes in both fields
    startDateInput.addEventListener("change", handleDateChange);
    endDateInput.addEventListener("change", handleDateChange);
    durationTypeInput.addEventListener("change", handleDateChange);

    $(".duration_type").on("change", function () {
        handleDateChange();
    });

    $vacationTypeInput.on("change", function () {
        handleVacationTypeChange();
    });

    // Function to handle date validation only
    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        // Check if the end date is earlier than the start date
        if (endDate && startDate && endDate < startDate) {
            return false; // Return false if dates are invalid
        } else {
            return true; // Dates are valid
        }
    }

    // Function to calculate and display the number of days (only if duration input exists)
    function calculateDays() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const durationType = durationTypeInput.value;
        const vacationType = document.getElementById("vacation_type")?.value;

        if (durationInput && startDate && endDate && durationType) {
            let count = 0;

            if (durationType === "days") {
                const normalizedStart = new Date(startDate);
                const normalizedEnd = new Date(endDate);
                normalizedStart.setHours(0, 0, 0, 0);
                normalizedEnd.setHours(0, 0, 0, 0);

                let currentDate = new Date(normalizedStart);

                while (currentDate <= normalizedEnd) {
                    const day = currentDate.getDay();
                    if (day !== 5 && day !== 6) {
                        // Skip Friday and Saturday
                        count++;
                    }
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            } else if (durationType === "hours") {
                const diff = endDate - startDate;
                count = Math.round(diff / (1000 * 60 * 60));
            }

            durationInput.value = count;

            // BALANCE CHECK for annual vacations only
            if (
                typeof requestType !== "undefined" &&
                requestType === "vacation" &&
                vacationType === "annual"
            ) {
                const remainingBalance = parseFloat(
                    document.getElementById("remaining_balance")?.value || 0
                );

                if (count > remainingBalance) {
                    durationInput.classList.add("is-invalid");
                    document.getElementById("balance-warning").style.display =
                        "block";
                } else {
                    document.getElementById("balance-warning").style.display =
                        "none";
                    durationInput.classList.remove("is-invalid");
                }
            } else {
                // If not applicable, remove any previous error styles
                durationInput.classList.remove("is-invalid");
                errorMessage.style.display = "none";
            }
        }
    }

    function handleVacationTypeChange() {
        const selectedType = $vacationTypeInput.value;
        if (selectedType !== "annual") {
            document.getElementById("balance-warning").style.display = "none";
            durationInput.classList.remove("is-invalid");
        }
        handleDateChange();
    }

    // function calculateDays() { // before remaining days update
    //         const startDate = new Date(startDateInput.value);
    //         const endDate = new Date(endDateInput.value);
    //         const durationType = durationTypeInput.value;

    //         if (durationInput && startDate && endDate && durationType) {
    //             if (durationType === 'hours') {
    //                 const timeDifference = endDate - startDate;
    //                 const hoursDifference = timeDifference / (1000 * 60 * 60);
    //                 durationInput.value = Math.round(hoursDifference);
    //             } else if (durationType === 'days') {
    //                 // Normalize time to ignore hours/minutes/seconds
    //                 const normalizedStart = new Date(startDate);
    //                 const normalizedEnd = new Date(endDate);
    //                 normalizedStart.setHours(0, 0, 0, 0);
    //                 normalizedEnd.setHours(0, 0, 0, 0);

    //                 let count = 0;
    //                 let currentDate = new Date(normalizedStart);

    //                 while (currentDate <= normalizedEnd) {
    //                     const day = currentDate.getDay();
    //                     if (day !== 5 && day !== 6) { // Skip Friday (5) and Saturday (6)
    //                         count++;
    //                     }
    //                     currentDate.setDate(currentDate.getDate() + 1);
    //                 }

    //                 durationInput.value = count;
    //             }
    //         } else if (durationInput) {
    //             durationInput.value = '';
    //         }
    //     }

    // function calculateDays() { // NOT Ignoring FRIDAY
    //     const startDate = new Date(startDateInput.value);
    //     const endDate = new Date(endDateInput.value);
    //     const durationType = durationTypeInput.value;

    //     if (durationInput && startDate && endDate && durationType) {
    //         if (durationType == 'hours') {
    //             const timeDifference = endDate - startDate;
    //             const daysDifference = timeDifference / (1000 * 60 * 60); // Convert milliseconds to days
    //             durationInput.value = Math.round(daysDifference);  // Update the duration input with the calculated days
    //         }
    //         else if (durationType == 'days') {
    //             const timeDifference = endDate - startDate;
    //             const daysDifference = timeDifference / (1000 * 60 * 60 * 24) + 1; // Convert milliseconds to days
    //             durationInput.value = Math.round(daysDifference);  // Update the duration input with the calculated days
    //         }
    //     } else if (durationInput) {
    //         // Clear the input if the dates are invalid
    //         durationInput.value = '';
    //     }
    // }

    // Function to handle both validation and days calculation (if applicable)
    function handleDateChange() {
        if (validateDates()) {
            calculateDays(); // Call calculateDays only if duration input exists
        }
    }
});
