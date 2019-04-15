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
            $this->session->set_flashdata('error', 'You are not allowed to signup!');
            redirect(site_url('login/register'), 'refresh');
            return;
        }

        // Else, we continue
        $this->session->set_flashdata('success', 'Welcome, '.$allowed->name);
        redirect(site_url('login/register'), 'refresh');
    }
}