/**
 * Dashboard Widgets - Simple Drag and Drop
 */
document.addEventListener("DOMContentLoaded", function() {
    if (typeof Sortable === "undefined") return;
    
    document.querySelectorAll("#kt_app_content_container > .row").forEach(function(row) {
        if (row.id === "announcement-card") return;
        
        new Sortable(row, {
            animation: 150,
            handle: ".card-header",
            draggable: "[class*=col-]",
            ghostClass: "sortable-ghost"
        });
    });
    
    var style = document.createElement("style");
    style.textContent = ".sortable-ghost { opacity: 0.4; background: #f0f8ff; } .card-header { cursor: grab; }";
    document.head.appendChild(style);
});
