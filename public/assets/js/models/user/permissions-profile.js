document.addEventListener("DOMContentLoaded", function () {
    const profileCheckboxes = document.querySelectorAll(".profile-select");
    const roleCheckboxes = document.querySelectorAll('input[name^="roles"]');
    const adminCheckbox = document.getElementById("admin_checkbox");

    // Function to toggle disabled state of all permission checkboxes
    function togglePermissions() {
        const isAdmin = adminCheckbox.checked;
        roleCheckboxes.forEach((checkbox) => {
            checkbox.disabled = isAdmin;
        });
    }

    // Initialize based on admin checkbox state
    togglePermissions();

    // Admin checkbox change event
    adminCheckbox.addEventListener("change", function () {
        togglePermissions();
    });

    // Prevent checking/unchecking when admin is selected
    roleCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("click", function (e) {
            if (adminCheckbox.checked) {
                e.preventDefault();
            }
        });
    });

    // Profile selection logic
    profileCheckboxes.forEach((box) => {
        box.addEventListener("change", function () {
            // If admin is checked, don't allow profile changes
            if (adminCheckbox.checked) {
                this.checked = false;
                return;
            }

            profileCheckboxes.forEach((b) => {
                if (b !== box) b.checked = false;
            });

            if (!box.checked || box.value === "custom") {
                return;
            }

            const selectedProfile = box.value;
            const profileData = permissionsProfiles[selectedProfile];

            roleCheckboxes.forEach((cb) => (cb.checked = false));

            for (const [roleName, levels] of Object.entries(profileData)) {
                levels.forEach((level) => {
                    const checkboxSelector = `input[name="roles[${roleMap[roleName]}][]"][value="${level}"]`;
                    const checkbox = document.querySelector(checkboxSelector);
                    if (checkbox) checkbox.checked = true;
                });
            }
        });
    });
});

// OLD CODE

// document.addEventListener('DOMContentLoaded', function () {
//     const profileCheckboxes = document.querySelectorAll('.profile-select');
//     const roleCheckboxes = document.querySelectorAll('input[name^="roles"]');

//     profileCheckboxes.forEach(box => {
//         box.addEventListener('change', function () {
//             profileCheckboxes.forEach(b => { if (b !== box) b.checked = false });

//             if (!box.checked || box.value === 'custom') {
//                 return;
//             }

//             const selectedProfile = box.value;
//             const profileData = permissionsProfiles[selectedProfile];

//             roleCheckboxes.forEach(cb => cb.checked = false);

//             for (const [roleName, levels] of Object.entries(profileData)) {
//                 levels.forEach(level => {
//                     const checkboxSelector = `input[name="roles[${roleMap[roleName]}][]"][value="${level}"]`;
//                     const checkbox = document.querySelector(checkboxSelector);
//                     if (checkbox) checkbox.checked = true;
//                 });
//             }
//         });
//     });
// });
