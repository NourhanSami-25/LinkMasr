// Arabic language configuration for DataTables
const arabicDataTableConfig = {
    language: {
        "sProcessing": "جارٍ التحميل...",
        "sLengthMenu": "أظهر _MENU_ مدخلات",
        "sZeroRecords": "لم يعثر على أية سجلات",
        "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
        "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
        "sInfoPostFix": "",
        "sSearch": "ابحث:",
        "sUrl": "",
        "oPaginate": {
            "sFirst": "الأول",
            "sPrevious": "السابق",
            "sNext": "التالي",
            "sLast": "الأخير"
        }
    }
};

// Function to initialize DataTable with Arabic language
function initArabicDataTable(selector, options = {}) {
    const table = document.querySelector(selector);
    if (table) {
        const defaultOptions = {
            order: [[0, 'desc']],
            pageLength: 25,
            ...arabicDataTableConfig
        };
        
        const finalOptions = { ...defaultOptions, ...options };
        return $(table).DataTable(finalOptions);
    }
    return null;
}