$(document).ready(function () {
    function toggleRelatedFields() {
        const selectedValue = $(".task-relation-type").val();
        $(".secondary-selects").hide();

        if (selectedValue === "project") {
            $(".select-project").show();
        } else if (selectedValue === "client") {
            $(".select-client").show();
        }
    }

    $(".task-relation-type").on("change", toggleRelatedFields);

    // Auto-select related type if one of the IDs is present
    if ($('select[name="project_id"]').val()) {
        $(".task-relation-type").val("project").trigger("change");
    } else if ($('select[name="client_id"]').val()) {
        $(".task-relation-type").val("client").trigger("change");
    } else {
        toggleRelatedFields(); // fallback
    }
});
