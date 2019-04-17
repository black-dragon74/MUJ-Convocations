<?php
defined('BASEPATH') or exit('Direct access not allowed');

class Alumni extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Alumni else get the fuck out
        $this->alumniElseGTFO();
    }

    private function alumniElseGTFO() {
        if ($this->session->userdata('alumni_login') != '1') {
            $this->session->set_flashdata('error', 'You must login first.');
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        $this->load->view('alumni/dashboard');
    }
}