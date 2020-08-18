function registerValidate() {
    var password = document.getElementById("password");
    var confirmPassword = document.getElementById("password-confirm");

    var checkValue = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;

    var validError = 'To check a password between 8 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character';
    var matchError = "Password and ConfrimPassword Mismatched."
    if (!password.value.match(checkValue)) {
        $('.registerValidationError').empty().text(validError).addClass('text-danger');
        password.focus();
        return false;
    }

    if (!confirmPassword.value.match(checkValue)) {
        $('.registerValidationError').empty().text(validError).addClass('text-danger');
        confirmPassword.focus();
        return false;
    }

    if (password.value != confirmPassword.value) {
        $('.registerValidationError').empty().text(matchError).addClass('text-danger');
        confirmPassword.focus();
        return false;
    }

    $('.registerValidationError').empty();

    return (true);
}
