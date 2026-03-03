document.addEventListener("DOMContentLoaded", function () {
    // Hide entire announcement card
    const hideBtn = document.getElementById("hide-announcement-card");
    if (hideBtn) {
        hideBtn.addEventListener("click", function (e) {
            e.preventDefault();
            let card = document.getElementById("announcement-card");
            if (card) {
                card.style.transition = "opacity 0.5s ease-out";
                card.style.opacity = "0";
                setTimeout(() => card.style.display = "none", 500);
            }
        });
    }

    // Hide individual announcement
    document.querySelectorAll(".remove-announcement").forEach(button => {
        button.addEventListener("click", function () {
            let announcementId = this.getAttribute("data-id");
            let announcement = document.getElementById();
            if (announcement) {
                announcement.style.transition = "opacity 0.5s ease-out";
                announcement.style.opacity = "0";
                setTimeout(() => announcement.remove(), 500);
            }
        });
    });
});
