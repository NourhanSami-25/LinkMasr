

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    // Define font URLs that JavaScript can access
    window.fontUrls = {
        cairoRegular: "{{ asset('assets/fonts/Cairo-Regular.ttf') }}",
        cairoBold: "{{ asset('assets/fonts/Cairo-Bold.ttf') }}"
    };
</script>
<script src="{{ asset('assets/js/pdfmake-fonts.js') }}"></script> {{-- Add this --}}
<script src="{{ asset('assets/js/custom/apps/ecommerce/reports/shipping/shipping.js') }}"></script>  {{-- used for exprt and filteration --}}





<script>
    // Disable DataTables error alerts - log to console instead
    $.fn.dataTable.ext.errMode = 'none';
    
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            // Use only local translations - no CDN loading
            sInfo: "{{ __('general.datatable_info') }}",
            sLengthMenu: "{{ __('general.datatable_sLengthMenu') }}",
            sSearch: "{{ __('general.datatable_sSearch') }}",
            sZeroRecords: "{{ __('general.datatable_sZeroRecords') }}",
            sInfoEmpty: "{{ __('general.datatable_sInfoEmpty') }}",
            sInfoFiltered: "{{ __('general.datatable_sInfoFiltered') }}",
            paginate: {
                sFirst: "{{ __('general.datatable_sFirst') }}",
                sPrevious: "{{ __('general.datatable_sPrevious') }}",
                sNext: "{{ __('general.datatable_sNext') }}",
                sLast: "{{ __('general.datatable_sLast') }}"
            }
        }
    });
    
    // Handle DataTables errors silently
    $(document).on('error.dt', function(e, settings, techNote, message) {
        console.log('DataTables warning: ', message);
        e.preventDefault();
    });
</script>
