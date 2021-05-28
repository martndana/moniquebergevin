$(document).ready(function () {
    let contactFormBtn = $('#sendBtn');

    contactFormBtn.on('click', sendEmailMessage);
})

function sendEmailMessage() {
    let contactForm = $('#contactForm');

    let fullName = contactForm.find('#txtName').val();
    let email = contactForm.find('#txtEmail').val();
    let subject = contactForm.find('#txtSubject').val();
    let message = contactForm.find('#taMessage').val();

    let params = { fullName, email, subject, message };

    // Validation
    let err = false;
    let errMessage = "The following information is either missing or invalid: <br>";
    contactForm.find('#txtName').removeClass('alert-danger');
    contactForm.find('#txtEmail').removeClass('alert-danger');
    contactForm.find('#txtSubject').removeClass('alert-danger');
    contactForm.find('#taMessage').removeClass('alert-danger');

    if (fullName === "") {
        err = true;
        errMessage += "- Name<br>";
        contactForm.find('#txtName').addClass('alert-danger');
    }

    if (email === "") {
        err = true;
        errMessage += "- Email Adrdress<br>";
        contactForm.find('#txtEmail').addClass('alert-danger');
    }

    if (subject === "") {
        err = true;
        errMessage += "- Suject<br>";
        contactForm.find('#txtSubject').addClass('alert-danger');
    }

    if (message === "") {
        err = true;
        errMessage += "- Message<br>";
        contactForm.find('#taMessage').addClass('alert-danger');
    }

    if (err) {
        displayFail(errMessage);
    } else {

        $.ajax({
            url: './../includes/mail_handler.inc.php',
            method: 'POST',
            data: params,
            dataType: 'json',
            // cache: 'false',
            // contentType: 'false',
            // processData: 'false',

            success: function (result) {
                if (result.success) {
                    displaySuccess(result.response);
                } else {
                    displayFail(result.error);
                }
            },

            error: (e) => {
                displayFail("An error occured when attempting to connect with the server.  <br>Please try again later.", "Unknown Error");
            }
        }) //End of AJAX

    }

    // Ajax success
    function displaySuccess() {
        $('#contactForm').hide();
        $('#emailResult').removeClass('alert alert-danger')
        $('#emailResult').addClass('alert alert-success')
        $('#emailResult').html('Your email was sent.  Thank you.')
    }

    // Ajax Fail
    function displayFail(e) {
        $('#emailResult').removeClass('alert alert-success')
        $('#emailResult').addClass('alert alert-danger')
        $('#emailResult').html(e)
    }

}