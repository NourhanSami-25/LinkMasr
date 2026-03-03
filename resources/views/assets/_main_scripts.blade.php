<script>var hostUrl = "assets/";</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/forms/confirmation.js') }}"></script>
<script src="{{ asset('assets/js/models/notification/notification-icon.js') }}"></script>
<script src="{{ asset('assets/js/models/todo/todo-icon.js') }}"></script>

<!-- Tagify CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.css" rel="stylesheet">

<!-- Tagify JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.js"></script>


<script>
    const i18n = {
        leaveTitle: @json(__('general.leave_confirmation_title')),
        leaveMessage: @json(__('general.leave_confirmation_message')),
        deleteTitle: @json(__('general.delete_confirmation_title')),
        deleteMessage: @json(__('general.delete_confirmation_message')),
        leaveButton: @json(__('general.leave')),
        stayButton: @json(__('general.stay')),
        deleteButton: @json(__('general.delete')),
        cancelButton: @json(__('general.cancel')),
    };
</script>

{{-- Sctipt to prevent the url appear in bottom left the screen --}}
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a').forEach(link => {
        const href = link.getAttribute('href');

        if (
            href &&
            !href.startsWith('javascript:') &&
            !href.startsWith('#') &&
            !href.includes('#') && // Don't touch fragment/anchor/tab links
            !link.hasAttribute('data-bs-toggle')
        ) {
            link.setAttribute('data-href', href);
            link.removeAttribute('href');
            link.style.cursor = 'pointer';

            link.addEventListener('click', function () {
                window.location.href = this.getAttribute('data-href');
            });
        }
    });
});
</script> --}}

{{-- زر المساعدة العائم - يظهر في جميع الصفحات --}}
@include('components.floating-help-button')
    