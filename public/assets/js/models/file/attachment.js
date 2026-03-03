function setupFileInputDisplay(inputId = 'attachments', outputId = 'file-chosen') {
    const fileInput = document.getElementById(inputId);
    const fileChosen = document.getElementById(outputId);

    if (!fileInput || !fileChosen) return;

    fileInput.addEventListener('change', function () {
        const files = Array.from(this.files).map(file => file.name);
        fileChosen.textContent = files.length > 0 ? files.join(', ') : 'No files chosen';
    });
}
