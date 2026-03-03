<script>
    const i118n = {
        leaveTitle: '{{ __("general.delete_confirmation_title") }}',
        leaveMessage: '{{ __("general.delete_confirmation_message") }}',
        leaveButton: '{{ __("general.delete") }}',
        stayButton: '{{ __("general.cancel") }}',
        deleteLabel: '{{ __("general.delete") }}',
        youLabel: '{{ __("general.you") }}'
    };
    window.userId = {{ auth()->id() }};
</script>
<script src="{{ asset('assets/js/models/discussion/form.js') }}"></script>
