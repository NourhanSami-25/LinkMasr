// Wait for the DOM to load before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const errorMessage = document.getElementById('date-error');
    const daysNumberInput = document.getElementById('duration');  // This may or may not exist

    // Add event listeners to detect changes in both fields
    startDateInput.addEventListener('change', handleDateChange);
    endDateInput.addEventListener('change', handleDateChange);

    // Function to handle date validation only
    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        // Check if the end date is earlier than the start date
        if (endDate && startDate && endDate < startDate) {
            errorMessage.textContent = 'End date must be after the start date.';
            errorMessage.style.display = 'block';
            endDateInput.classList.add('error');
            return false; // Return false if dates are invalid
        } else {
            errorMessage.style.display = 'none';
            endDateInput.classList.remove('error');
            return true; // Dates are valid
        }
    }

    // Function to calculate and display the number of days (only if duration input exists)
    function calculateDays() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (daysNumberInput && startDate && endDate && validateDates()) {
            const timeDifference = endDate - startDate;
            const daysDifference = timeDifference / (1000 * 60 * 60 * 24) + 1; // Convert milliseconds to days
            // Update the duration input with the calculated days
            daysNumberInput.value = Math.round(daysDifference);  // Round to nearest whole number
        } else if (daysNumberInput) {
            // Clear the input if the dates are invalid
            daysNumberInput.value = '';
        }
    }

    // Function to handle both validation and days calculation (if applicable)
    function handleDateChange() {
        if (validateDates()) {
            calculateDays(); // Call calculateDays only if duration input exists
        }
    }
});
