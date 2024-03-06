<?php
$receiving_email_address = 'contact@example.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);

    $contact->ajax = true;

    $contact->to = $receiving_email_address;
    $contact->from_name = isset($_POST['name']) ? $_POST['name'] : '';
    $contact->from_email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact->subject = isset($_POST['subject']) ? $_POST['subject'] : '';

    // Uncomment below code if you want to use SMTP to send emails.
    /*
    $contact->smtp = array(
      'host' => 'example.com',
      'username' => 'example',
      'password' => 'pass',
      'port' => '587'
    );
    */

    // Validate and sanitize form data
    $name = filter_var($contact->from_name, FILTER_SANITIZE_STRING);
    $email = filter_var($contact->from_email, FILTER_SANITIZE_EMAIL);
    $subject = filter_var($contact->subject, FILTER_SANITIZE_STRING);

    // Add form data to the message
    $contact->add_message($name, 'From');
    $contact->add_message($email, 'Email');
    $contact->add_message(isset($_POST['message']) ? $_POST['message'] : '', 'Message', 10);

    // Send the email and handle errors
    $send_result = $contact->send();
    
    if ($send_result) {
        echo 'success';
    } else {
        echo 'error';
        // You can log or handle the error in a more detailed way if needed
    }
} else {
    die('Unable to load the "PHP Email Form" Library!');
}
?>
