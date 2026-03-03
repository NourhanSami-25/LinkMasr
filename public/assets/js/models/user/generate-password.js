document.getElementById('generate-password').addEventListener('click', function () {
    // Generate a random 10-character password
    var password = generateRandomPassword(10);
    // Set the password in the input field
    document.getElementById('password').value = password;
});
// Function to generate a random password of a given length
function generateRandomPassword(length) {
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
    var password = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        password += charset.charAt(Math.floor(Math.random() * n));
    }
    document.getElementById('plain_password').value = password;
    return password;
}