<?php
/**
 * Sends the email to the address in the params.
 *
 * @param $context
 * The application instance from which the function is being called
 * @param $subject
 * E-mail Subject
 * @param $to
 * E-mail receiptent
 * @param $message
 * The actual E-Mail message
 * @return bool
 * True if mail is dispatched else false
 */
function email($context, $subject, $to, $message) {
    // If any of the two params is empty, bail out
    if (empty($subject) || empty($to) || empty($message)) {
        return false;
    }

    // Else, we continue, load the email library and configure vars
    $config = array();

    // Set mail config
    $config['mailtype'] = 'html';
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.gmail.com';
    $config['smtp_user'] = 'hellouniversum@gmail.com';
    $config['smtp_pass'] = '****';
    $config['smtp_port'] = '465';
    $config['smtp_crypto'] = 'ssl';
    $config['newline'] = "\r\n";

    // Load the library
    $context->load->library('email');
    $context->email->initialize($config);

    // Basic thingies for an email
    $context->email->from('me@nicksuniversum.com', 'Nick');
    $context->email->to($to);
    $context->email->subject($subject);
    $context->email->message($message);

    // Send the email and return the boolean value
    if ($context->email->send()) {
        return true;
    }
    else {
        return false;
    }
}

/**
 * Returns a HTML mail template to be sent upon successful registration.
 *
 * @param $name
 * The user name (full name)
 * @param $password
 * The password to include in the email
 * @return string
 * The HTML formatted password email
 */
function getPasswordEmailHTML($name, $password) {
    $message = 'Hey '.$name.',<br>';
    $message .= 'Your registration is successful. You may login with the password: '.$password.'<br>';
    $message .= 'Login here: '.site_url('login').'<br>';
    $message .= 'Regards,<br>';
    $message .= 'MUJ Convocations';
    return $message;
}

/**
 * Returns a HTML mail template to be sent upon successful password reset.
 *
 * @param $name
 * The user name (full name)
 * @param $password
 * The password to include in the email
 * @return string
 * The HTML formatted password email
 */
function getPasswordResetEmailHTML($name, $password) {
    $message = 'Hey '.$name.',<br>';
    $message .= 'Your password has been resetted successfully. You may now login with the new password: '.$password.'<br>';
    $message .= 'Login here: '.site_url('login').'<br>';
    $message .= 'Regards,<br>';
    $message .= 'MUJ Convocations';
    return $message;
}

/**
 * Function to obfuscate the email address
 *
 * @param $email
 * Email address to mask
 * @return string
 * Masked email address
 */
function maskedEmail($email) {
    $em   = explode("@",$email);
    $name = implode(array_slice($em, 0, count($em)-1), '@');
    $len  = floor(strlen($name)/2);

    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
}