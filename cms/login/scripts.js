function login() {
    setError();
    setLoading(true);

    // Gets the data from the DOM
    let data = {
        username: $("#username").val(),
        password: $("#password").val(),
    };

    // Validates the data
    if (data.username === '') {
        setError('Username is required');
        $("#username").focus();
    }
    else if (data.password === '') {
        setError('Password is required');
        $("#password").focus();
    }
    else {

        // Request the login
        $.ajax({
            url: 'login/signin.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,

            // Process a request success
            success: function (result) {
                if (result.success) {
                    location.href = result.redirect;
                }
                else {
                    setError('Username and/or password invalid');
                }
            },

            // Process a request failure
            error: () => {
                setError('Failed to log in.');
            }
        });
    }
};

/**
 * Shows the error message on the page
 * @param {string} message The error message to be shown
 */
function setError(message) {
    let errorMessage = $("#errorMessage");
    if (message) {
        errorMessage.html(message);
        errorMessage.css({ display: 'block' });
        setLoading(false);
    }
    else {
        errorMessage.css({ display: 'none' });
    }
}

/**
 * Shows/Hides the loading message on the page
 * @param {bool} state The loading state
 */
function setLoading(state) {
    if (state) {
        $("#buttonLogin").css({ display: 'none' });
        $("#buttonLoading").css({ display: 'block' });
    } else {
        $("#buttonLogin").css({ display: 'block' });
        $("#buttonLoading").css({ display: 'none' });
    }
}