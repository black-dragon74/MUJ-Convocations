<?php


class Maintenance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('convocation');
    }


    public function index() {
        if (getConfig($this, 'site_offline') != '1') {
            // To reflect the live changes in the site active state
            if ($this->session->userdata('maintenance') == '1') {
                $this->session->unset_userdata('maintenance');
                redirect(site_url('login'), 'refresh');
            }
        }
        else {
            $this->load->view('maintenance');
        }
    }
}