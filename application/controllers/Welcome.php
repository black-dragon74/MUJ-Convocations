<?php
defined('BASEPATH') or exit('Direct access not allowed');

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Loads the home page (welcome)
    public function index()
    {
        $data['title'] = 'Welcome';
        $this->load->view('welcome/welcome', $data);
    }

    // Loads the guidelines page
    public function guidelines()
    {
        $data['title'] = 'Guidelines';
        $this->load->view('welcome/guidelines', $data);
    }

    // Loads the instructions page
    public function instructions()
    {
        $data['title'] = 'Instructions';
        $this->load->view('welcome/instructions', $data);
    }

    // Loads the contact page
    public function contact()
    {
        $data['title'] = 'Contact Us0';
        $this->load->view('welcome/contact', $data);
    }


}