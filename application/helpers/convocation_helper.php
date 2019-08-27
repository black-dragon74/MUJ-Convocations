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
    $config['smtp_host'] = 'smtp.hostinger.in';
    $config['smtp_user'] = 'noreply@convocationmuj.net';
    $config['smtp_pass'] = '6oq2zfGczGqf';
    $config['smtp_port'] = '587';
    $config['smtp_crypto'] = 'tls';
    $config['newline'] = "\r\n";

    // Load the library
    $context->load->library('email');
    $context->email->initialize($config);

    // Basic thingies for an email
    $context->email->from('noreply@convocationmuj.net', 'MUJ Convocations');
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
 * @param $regNo
 * The Registration number of the user
 * @param $password
 * The password to include in the email
 * @return string
 * The HTML formatted password email
 */
function getPasswordEmailHTML($name, $regNo, $password) {
    $message = 'Hey '.$name.',<br><br>';
    $message .= 'Greetings from Manipal University Jaipur.<br>';
    $message .= 'You have successfully signed up for convocation portal.<br>';
    $message .= 'Your login id is: <b>' . $regNo .'</b> and password is: <b>'. $password.'</b><br><br>';
    $message .= 'Login at: '.site_url('login').' for the further registration process.<br>';
    $message .= 'See you at the convocation ceremony.<br><br>';
    $message .= 'Regards,<br>';
    $message .= 'Team Convocation<br>';
    $message .= 'Manipal University Jaipur';
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

/**
 * @param $context
 * Application's context
 * @param $message
 * Error message
 * @param $url
 * Redirect back to this URL
 */
function redirectError($context, $message, $url) {
    $context->session->set_flashdata('error', $message);
    redirect(site_url($url), 'refresh');
}

/**
 * @param $context
 * Application's context
 * @param $message
 * Success message
 * @param $url
 * Redirect back to this URL
 */
function redirectSuccess($context, $message, $url) {
    $context->session->set_flashdata('success', $message);
    redirect(site_url($url), 'refresh');
}

/**
 * @param $ctx
 * Context
 * @param $config
 * Config key
 * @param $value
 * Config value
 * @return bool
 * Whether the config was set or not
 */
function setConfig($ctx, $config, $value) {
    $ctx->db->where('name', $config);
    $update = $ctx->db->update('config', array(
        'value' => $value
    ));

    return $update ? true : false;
}

/**
 * @param $ctx
 * Context
 * @param $config
 * Config key
 * @return mixed
 * Config value if exists in the DB else false
 */
function getConfig($ctx, $config) {
    $resp = $ctx->db->get_where('config', array(
        'name' => $config
    ));

    return $resp ? $resp->row()->value : false;
}