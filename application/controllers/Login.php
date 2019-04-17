<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * Login controller handles the login for alumi or the admins
     *
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // We need to load our custom helper, that will load the email library
        $this->load->helper('convocation');


    }

    /**
     * This function just renders the login web page to the user
     */
    public function index() {
        $data['title'] = 'Login';
        $this->load->view('login', $data);
    }

    /**
     * I just load the register page
     */
    public function register() {
        $data['title'] = 'Register';
        $this->load->view('register', $data);
    }

    /**
     * This function handles the registration of the user
     */
    public function validate_registration() {
        // Send those tinkerers away
        isset($_POST['regNo']) OR die();

        // Store the registration number in a local variable
        $regNo = $_POST['regNo'];

        // Now we check if this user is allowed to register, if yes, we generate a random password
        $allowed = $this->db->get_where('whitelist', array('regno' => $regNo))->row();

        // If not allowed, redirect back to login!
        if (!$allowed) {
            $this->session->set_flashdata('error', 'You are not eligible to signup.');
            redirect(site_url('login/register'), 'refresh');
            return;
        }

        // Else, we continue in the steps mentioned below
        // Step 0, if the user is already registered, he cannot register again
        $alreadyRegistered = $this->db->get_where('users', array('regno' => $allowed->regno))->row();

        if ($alreadyRegistered) {
            $this->session->set_flashdata('error', 'You are already registered. Please login.');
            redirect(site_url('login/register'), 'refresh');
            return;
        }

        // Step 1, generate a random password
        $generatedPassword = substr(md5(rand(100000000,20000000000)), 0, 10);

        $name = $allowed->name;
        $content = getPasswordEmailHTML($name, $generatedPassword);

        // Step 2, send the email, if it is successful, update the password in the database
        $userEmail = $allowed->email;
        if (!email($this, 'Registration Successful', $userEmail, $content)) {
            #show_error($this->email->print_debugger());
            $this->session->set_flashdata('error', 'Failed to send the password mail.');
            redirect(site_url('login/register'), 'refresh');
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($generatedPassword, PASSWORD_BCRYPT);

        $dbresult = $this->db->insert('users', array(
            'regno' => $allowed->regno,
            'password' => $hashedPassword,
            'confirmed' => 0
        ));

        if ($dbresult) {
            $this->session->set_flashdata('success', 'Password sent to your email '.maskedEmail($userEmail));
            redirect(site_url('login/register'), 'refresh');
        }
        else {
            $this->session->set_flashdata('error', 'Failed to register the user.');
            redirect(site_url('login/register'), 'refresh');
        }
    }

    /**
     * This function validates the login request for the user
     */
    public function validate_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
            return;
        }

        //TODO:- Check if the user is admin

        // Check if the user is an alumni
        $isAlumni = $this->db->get_where('users', array('regno' => $username))->row();

        if (!$isAlumni) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect(site_url('login'), 'refresh');
            return;
        }

        // Else, we check if the user has supplied a correct password
        $hashedPassword = $isAlumni->password;
        if (password_verify($password, $hashedPassword)) {
            // Logim
            $this->session->set_userdata('alumni_login', '1');
            $this->session->set_userdata('regno', $isAlumni->regno);
            $this->session->set_userdata('confirmed', $isAlumni->confirmed);
            $alumniName = $this->db->get_where('whitelist', array('regno' => $username))->row()->name;
            $this->session->set_userdata('name', $alumniName);
            redirect(site_url('alumni'), 'refresh');
            return;
        }
        else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect(site_url('login'), 'refresh');
            return;
        }
    }

    /**
     * Logs out and clears all userdata for the session
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url('login'), 'refresh');
    }

    /**
     * Just loads the forgot password view
     */
    public function forgot_password() {
        $data['title'] = 'Reset Password';
        $this->load->view('forgot', $data);
    }

    /**
     * Handles the password reset
     */
    public function reset_password() {
        $username = $this->input->post('username');

        if (empty($username)) {
            return;
        }

        // Check if the user is registered else send him back
        $validUser = $this->db->get_where('users', array('regno' => $username))->row();

        if (!$validUser) {
            $this->session->set_flashdata('error', 'Password reset not allowed.');
            redirect(site_url('login/forgot_password'), 'refresh');
            return;
        }

        // Step 1, Generate a new password
        $generatedPassword = substr(md5(rand(100000000,20000000000)), 0, 10);

        $name = $this->db->get_where('whitelist', array('regno' => $username))->row()->name;
        $content = getPasswordResetEmailHTML($name, $generatedPassword);

        // Step 2, send the email, if it is successful, update the password in the database
        $userEmail = $this->db->get_where('whitelist', array('regno' => $username))->row()->email;
        if (!email($this, 'Password Reset', $userEmail, $content)) {
            # show_error($this->email->print_debugger());
            $this->session->set_flashdata('error', 'Failed to send the password reset mail.');
            redirect(site_url('login/forgot_password'), 'refresh');
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($generatedPassword, PASSWORD_BCRYPT);

        $dbresult = $this->db->update('users', array(
            'password' => $hashedPassword
        ));

        if ($dbresult) {
            $this->session->set_flashdata('success', 'Password resetted and sent to your email '.maskedEmail($userEmail));
            redirect(site_url('login/forgot_password'), 'refresh');
        }
        else {
            $this->session->set_flashdata('error', 'Failed to reset the password.');
            redirect(site_url('login/forgot_password'), 'refresh');
        }
    }
}