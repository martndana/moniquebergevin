<?php

    // Constant
    define(_SENDTO_, 'bergevinm@mjbwebdesigns.ca');

    $result = [
        'success' => true,
        'error' => '',
        'response' => null
    ];

    function setError($message) {
        global $result;
        $result['success'] = false;
        $result['error'] = $message;
    }

    if (
        isset($_POST['fullName'])
        && isset($_POST['email'])
        && isset($_POST['subject'])
        && isset($_POST['message'])
    ) {
        $fullName = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        $toEmail = "bergevinm@mjbwebdesigns.ca";
        $emailSubject = "Website Email From " . $fullName;
        $body = "<h2>" . $subject . "</h2>
            <h4>Name</h4><p>" . $fullname . "</p>
            <h4>Email</h4><p>" . $email . "</p>
            <h4>Message</h4><p>" . $message . "</p>
        ";

        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

        // ini_set("SMTP","smtp.example.com" );
        // ini_set('sendmail_from', 'user@example.com');

        if(mail($toEmail, $emailSubject, $body, $headers)) {
            $result['response'] = 'Your email was sent.  Thank you.';
        } else {
            setError('Problem sending your email.  Please try again later.');
        }

    } else {
        setError('Problem on the input - ' . $_POST['fullName']);
    }

    //  Return result
    header('Content-type: application/json');
    echo json_encode($result);
