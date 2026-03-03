"use strict";

// Class definition
class KTDataTableManager {
    constructor(tableElement) {
        // Store instance variables
        this.table = tableElement;
        this.datatable = null;
        this.tableId = this.table.id;

        // Initialize
        this.initDatatable();
        this.initDaterangepicker();
        this.exportButtons();
        this.handleSearchDatatable();
        this.handleStatusFilter();
    }

    // Private methods
    initDatatable() {
        // Set date data order
        const tableRows = this.table.querySelectorAll("tbody tr");

        tableRows.forEach((row) => {
            const dateRow = row.querySelectorAll("td");
            const realDate = moment(
                dateRow[0].innerHTML,
                "MMM DD, YYYY"
            ).format();
            dateRow[0].setAttribute("data-order", realDate);
        });

        // Init datatable
        this.datatable = $(this.table).DataTable({
            info: false,
            order: [],
            pageLength: 10,
        });
    }

    initDaterangepicker() {
        var start = moment().subtract(29, "days");
        var end = moment();
        var input = $(`#${this.tableId}_daterangepicker`);

        function cb(start, end) {
            input.html(
                start.format("MMMM D, YYYY") +
                    " - " +
                    end.format("MMMM D, YYYY")
            );
        }

        input.daterangepicker(
            {
                startDate: start,
                endDate: end,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
            },
            cb
        );

        cb(start, end);
    }

    handleStatusFilter() {
        const filterStatus = document.querySelector(
            `[data-kt-table="${this.tableId}"][data-kt-filter="status"]`
        );
        if (!filterStatus) return;

        $(filterStatus).on("change", (e) => {
            let value = e.target.value;
            if (value === "all") {
                value = "";
            }
            this.datatable.column(3).search(value).draw();
        });
    }

    exportButtons() {
        const documentTitle = "Report";
        var buttons = new $.fn.dataTable.Buttons(this.table, {
            buttons: [
                {
                    extend: "copyHtml5",
                    title: documentTitle,
                },
                {
                    extend: "excelHtml5",
                    title: documentTitle,
                },
                {
                    extend: "csvHtml5",
                    title: documentTitle,
                },
                // In your shipping.js, replace the pdfHtml5 button with this:
                {
                    extend: "pdfHtml5",
                    title: documentTitle,
                    customize: function (doc) {
                        // Simple font check and fallback
                        const fontFamily =
                            pdfMake.fonts && pdfMake.fonts.Cairo
                                ? "Cairo"
                                : "Roboto";

                        // Basic configuration
                        doc.defaultStyle = {
                            font: fontFamily,
                            fontSize: 10,
                            alignment: "right",
                        };

                        // Minimal styles definition
                        doc.styles = doc.styles || {};
                        doc.styles.tableHeader = {
                            bold: true,
                            fontSize: 11,
                            font: fontFamily,
                            alignment: "right",
                        };
                    },
                },
            ],
        })
            .container()
            .appendTo($(`#${this.tableId}_export`));

        // Hook dropdown menu click event to datatable export buttons
        const exportButtons = document.querySelectorAll(
            `#${this.tableId}_export_menu [data-kt-export]`
        );
        exportButtons.forEach((exportButton) => {
            exportButton.addEventListener("click", (e) => {
                e.preventDefault();
                const exportValue = e.target.getAttribute("data-kt-export");
                const target = document.querySelector(
                    `.dt-buttons .buttons-${exportValue}`
                );
                target.click();
            });
        });
    }

    handleSearchDatatable() {
        const filterSearch = document.querySelector(
            `[data-kt-table="${this.tableId}"][data-kt-filter="search"]`
        );
        if (!filterSearch) return;

        filterSearch.addEventListener("keyup", (e) => {
            this.datatable.search(e.target.value).draw();
        });
    }
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
    // Initialize all tables with class 'kt-datatable'
    document.querySelectorAll(".kt-datatable").forEach((table) => {
        new KTDataTableManager(table);
    });
});
