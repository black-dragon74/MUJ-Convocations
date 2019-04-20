<?php
defined('BASEPATH') or exit('Direct access not allowed');

// PayTM pg related stuffs
require_once APPPATH.'libraries/config_paytm.php';
require_once APPPATH.'libraries/encdec_paytm.php';

class Alumni extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Alumni else get the fuck out
        $this->alumniElseGTFO();

        $this->load->helper('convocation');

        // If maintenance redirect
        if (getConfig($this, 'site_offline') == '1') {
            $this->session->set_userdata('maintenance', '1');
            redirect(site_url('maintenance'), 'refresh');
        }
        else {
            // To reflect the live changes in the site active state
            if ($this->session->userdata('maintenance') == '1') {
                $this->session->unset_userdata('maintenance');
                redirect(site_url('login'), 'refresh');
            }
        }
    }

    private function alumniElseGTFO() {
        if ($this->session->userdata('alumni_login') != '1') {
            $this->session->set_flashdata('error', 'You must login first.');
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        // If the user has not completed the profile yet, redirect him back to profile page
        $username = $this->session->userdata('name');
        $regno = $this->session->userdata('regno');
        $confirmed = $this->db->get_where('users', array('regno' => $regno))->row()->confirmed;
        $this->session->set_userdata('confirmed', $confirmed);

        $eventArray = array();
        $events = $this->db->get_where('event_days', array('disabled' => '0'));  // Only the dates that are not disabled.
        if ($events) {
            $array = $events->result_array();
            foreach ($array as $ar) {
                array_push($eventArray, $ar);
            }
        }

        $data['username'] = $username;
        $data['regno'] = $regno;

        // Update the days
        if (count($eventArray) > 0) {
            $data['events'] = $eventArray;
        }

        if ($confirmed != '1') {
            $data['title'] = 'Complete Profile';
            $this->load->view('alumni/complete_profile', $data);
        }
        else {
            $data['title'] = 'Dashboard';
            $this->load->view('alumni/dashboard', $data);
        }
    }

    /**
     * I setup the profile for the alumni
     */
    public function setup_profile() {
        // We have to update two tables upon receiving this request
        // First, we update the user's table with basic details
        // Then, we update the alumni table with the name, regno, mobile and mail

        // The variables that we need
        $regno = $this->input->post('alumni-regno');
        $attendDay = $this->input->post('alumni-attend-day');
        $withParent = $this->input->post('alumni-parents'); // 1 means coming with parents
        $formType  = $this->input->post('alumni-formtype');  // 1 if sending via post
        $address = $this->input->post('alumni-address');
        $altMobile = $this->input->post('alumni-alt-mobile');
        $linkedin = $this->input->post('alumni-linkedin');
        $facebook = $this->input->post('alumni-facebook');
        $instagram = $this->input->post('alumni-instagram');
        $pincode = $this->input->post('alumni-pincode');
        $currentState = $this->input->post('alumni-current-state');
        $aux1 = $this->input->post('aux1');
        $aux2 = $this->input->post('aux2');
        $aux3 = $this->input->post('aux3');

        // Update the details in the student table
        $confirmed = $this->session->userdata('confirmed');

        // If not confirmed, then proceed. this will always be false BTW. Else, user won't see this page.
        if ($confirmed == '1') {
            $this->session->set_flashdata('error', 'Profile is already complete');
            redirect(site_url('alumni'), 'refresh');
        }

        // User's table payload
        $userPayload = array(
            'day' => $attendDay == '' ? 0 : $attendDay,
            'formtype' => $formType,
            'parents' => $withParent == '' ? 0 : $withParent,
            'confirmed' => 1
        );

        // Alumni table payload
        $alumniPayload = array(
            'alt_mobile' => $altMobile,
            'address' => $address,
            'linkedin' => $linkedin,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'pincode' => $pincode
        );

        // Dynamic alumni payload creation based on user preference
        switch ($currentState) {
            case 'employed':
                $alumniPayload['employer_name'] = $aux1;
                $alumniPayload['city'] = $aux2;
                $alumniPayload['designation'] = $aux3;
                break;
            case 'higher':
                $alumniPayload['university_name'] = $aux1;
                $alumniPayload['city'] = $aux2;
                $alumniPayload['program_name'] = $aux3;
                break;
            case 'business':
                $alumniPayload['firm_name'] = $aux1;
                $alumniPayload['city'] = $aux2;
                $alumniPayload['firm_type'] = $aux3;
                break;
            default:
                break;
        }

        // Update the user table now
        $this->db->where(array('regno' => $regno));
        $userUpdated = $this->db->update('users', $userPayload);

        if (!$userUpdated) {
            $this->session->set_flashdata('error', 'Unable to update your profile.');
            redirect(site_url('alumni'), 'refresh');
            return;
        }

        // Update the alumni table now
        // If already present, then, update else inset
        $alumniPresent = $this->db->get_where('alumni', array('regno' => $regno))->row();
        if ($alumniPresent) {
            $this->db->where(array('regno' => $regno));
            $alumniUpdated = $this->db->update('alumni', $alumniPayload);
        }
        else {
            // Insert the new record
            $this->session->set_flashdata('error', 'Unauthorized attempt to update user details');
            redirect(site_url('alumni'));
        }

        if (isset($alumniUpdated)) {
            if (!$alumniUpdated) {
                $this->session->set_flashdata('error', 'Unable to update your profile.');
                redirect(site_url('alumni'), 'refresh');
                return;
            }
        }

        // Else, we are done.
        $this->session->set_flashdata('success', 'Thank you for completing your profile..');
        redirect(site_url('alumni'), 'refresh');
    }

    /**
     * I handle the updation of the profile
     */
    public function update_profile() {
        // We have to update two tables upon receiving this request
        // First, we update the user's table with basic details
        // Then, we update the alumni table with the name, regno, mobile and mail

        // The variables that we need
        $regno = $this->input->post('alumni-regno');
        $address = $this->input->post('alumni-address');
        $altMobile = $this->input->post('alumni-alt-mobile');
        $linkedin = $this->input->post('alumni-linkedin');
        $facebook = $this->input->post('alumni-facebook');
        $instagram = $this->input->post('alumni-instagram');
        $pincode = $this->input->post('alumni-pincode');

        // Alumni table payload
        $alumniPayload = array(
            'alt_mobile' => $altMobile,
            'address' => $address,
            'linkedin' => $linkedin,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'pincode' => $pincode
        );

        // Update the alumni table now
        $this->db->where(array('regno' => $regno));
        $alumniUpdated = $this->db->update('alumni', $alumniPayload);

        if (!$alumniUpdated) {
            $this->session->set_flashdata('error', 'Unable to update your profile.');
            redirect(site_url('alumni'), 'refresh');
            return;
        }

        // Else, we are done.
        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect(site_url('alumni/account_settings'), 'refresh');
    }

    /**
     * I just load the review details section
     */
    public function review_details() {
        $username = $this->session->userdata('name');
        $regno = $this->session->userdata('regno');
        $data['username'] = $username;
        $data['regno'] = $regno;
        $data['title'] = 'Review Details';

        if ($this->session->userdata('confirmed') != '1') {
            redirect(site_url('alumni'), 'refresh');
        }

        $this->load->view('alumni/review', $data);
    }

    /**
     * I load the fee payment view
     */
    public function fee() {
        // If profile is not complete, redirect back
        if ($this->session->userdata('confirmed') != '1') {
            redirect(site_url('alumni'), 'refresh');
        }

        $username = $this->session->userdata('name');
        $regno = $this->session->userdata('regno');

        // If already paid, pass.
        $hasPaid = $this->db->get_where('users', array('regno' => $regno))->row();
        if ($hasPaid->paid == '1') {
            $this->session->set_flashdata('error', 'Fee already paid!');
            redirect(site_url('alumni'), 'refresh');
            return;
        }

        $data['regno'] = $regno;
        $data['username'] = $username;
        $data['title'] = 'Pay Fees';
        $this->load->view('alumni/pay', $data);
    }

    /**
     * The actual function that processes the payment
     */
    public function process_payment() {
        // If the user has already paid the fees, redirect back to dash
        $regno = $this->input->post('regno');

        // Sometimes it is better to die without any error messages.
        if ($regno == '') {
            die();
        }

        $hasPaid = $this->db->get_where('users', array('regno' => $regno))->row();
        $currUser = $this->db->get_where('alumni', array('regno' => $regno))->row();

        if ($hasPaid->paid == '1') {
            $this->session->set_flashdata('error', 'Fee already paid!');
            redirect(site_url('alumni'), 'refresh');
            return;
        }

        // Tell the browser to ignore the caches
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        // Now we need to construct the payment
        $paymentAmount = $hasPaid->formtype == '1' ? '300' : '1000';
        $paramList = array();

        $ORDER_ID = "ORDS" . rand(10000,99999999);
        $CUST_ID = 'USR'.$regno;
        $MSISDN = $currUser->mobile;
        $EMAIL = $currUser->email;
        $INDUSTRY_TYPE_ID = 'Retail';
        $CHANNEL_ID = 'WEB';
        $TXN_AMOUNT = $paymentAmount;

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["MSISDN"] = $MSISDN;
        $paramList["EMAIL"] = $EMAIL;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
        $paramList["CALLBACK_URL"] = site_url('alumni/payCallback');

        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

        // Render and submit the page (This is where PHP sucks)
        echo '<html lang="en">
              <head>
                <title>Processing Payment....</title>
              </head>
              <body>
                    <center><h1>Processing payment for Rs'.$paymentAmount.'. Please do not refresh the page.</h1></center>
                    <form method="post" action="'.PAYTM_TXN_URL.'" name="f1">';
        foreach ($paramList as $name => $value) {
            echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
        }
        echo '<input type="hidden" name="CHECKSUMHASH" value="'.$checkSum.'">';

        echo '<script type="text/javascript">
			document.f1.submit();
		    </script>';
        echo '</form></body></html>';
    }

    /**
     * PayTM PG responds back on this URL. Only PayTM is authorized to call this URL
     */
    public function payCallback() {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by PayTM PG

        // Check that the checksum has not been tampered with
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);

        if ($isValidChecksum == 'TRUE') {
            if ($paramList['STATUS'] == 'TXN_SUCCESS') {
                // Extract the details we need from the PG response
                $orderID = $paramList['ORDERID'];
                $txnID = $paramList['TXNID'];
                $txnDate = $paramList['TXNDATE'];
                $paid = '1';

                // Update the details in the user DB
                $userPayload = array(
                    'paid' => $paid,
                    'orderid' => $orderID,
                    'txnid' => $txnID,
                    'paymentdate' => $txnDate
                );

                $this->db->where('regno', $this->session->userdata('regno'));
                if ($this->db->update('users', $userPayload)) {
                    redirect(site_url('alumni/invoice'), 'refresh');
                }
            }
            else {
                $this->session->set_flashdata('error', 'Payment failed');
                redirect(site_url('alumni'), 'refresh');
            }
        }
        else {
            $this->session->set_flashdata('error', 'Payment was tampered with and hence has failed.');
            redirect(site_url('alumni'), 'refresh');
        }
    }

    /**
     * Generate the printable invoice for the user
     */
    public function invoice() {
        // If profile is not complete, redirect back
        if ($this->session->userdata('confirmed') != '1') {
            redirect(site_url('alumni'), 'refresh');
        }

        $regno = $this->session->userdata('regno');
        $currentUser = $this->db->get_where('users', array('regno' => $regno))->row();

        if ($currentUser->paid != '1') {
            $this->session->set_flashdata('error', 'You need to pay your fees first.');
            redirect(site_url('alumni/fee'), 'refresh');
            return;
        }

        // Else, we get the required details and load the invoice page
        $data['title'] = 'Print Invoice';
        $data['username'] = $this->session->userdata('name');
        $data['regno'] = $regno;
        $data['orderID'] = $currentUser->orderid;
        $data['txnID'] = $currentUser->txnid;

        // A little bit of formatting for the date
        $originalDate = $currentUser->paymentdate;
        $data['paymentDate'] = date("d-m-Y", strtotime($originalDate));

        // Further calculations for the payment amount, If form type is 1, 300 else 1000
        $formType = $currentUser->formtype;

        $paymentAmount = $formType == '1' ? '300.00' : '1000.00';
        $paymentDesc = $formType == '1' ? 'Postal handling charges' : 'Convocation uniform charges';

        $data['paymentAmount'] = $paymentAmount;
        $data['paymentDesc'] = $paymentDesc;

        $this->load->view('alumni/invoice', $data);
    }

    /**
     * I just load the account settings
     */
    public function account_settings() {
        // If profile is not complete, redirect back
        if ($this->session->userdata('confirmed') != '1') {
            redirect(site_url('alumni'), 'refresh');
        }

        $data['title'] = 'Account Settings';
        $data['regno'] = $this->session->userdata('regno');
        $data['username'] = $this->session->userdata('name');
        $this->load->view('alumni/account_settings', $data);
    }

    /**
     * I update the password for the user
     */
    public function update_password() {
        $regNo = $this->session->userdata('regno');
        $currentUser = $this->db->get_where('users', array('regno' => $regNo))->row();

        $password = $this->input->post('current-password');
        $newPassword = $this->input->post('new-password');
        $rePassword = $this->input->post('re-password');

        $oldPassword = $currentUser->password;

        if (!password_verify($password, $oldPassword)) {
            $this->session->set_flashdata('error', 'Existing password is not correct');
            redirect(site_url('alumni/account_settings'), 'refresh');
            return;
        }

        // Else now we compare both the passwords
        if ($newPassword != $rePassword) {
            $this->session->set_flashdata('error', 'New passwords do not match.');
            redirect(site_url('alumni/account_settings'), 'refresh');
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update in the database
        $this->db->where('regno', $regNo);
        $updated = $this->db->update('users', array('password' => $hashedPassword));

        if ($updated) {
            $this->session->set_flashdata('success', 'Password updated successfully.');
            redirect(site_url('alumni/account_settings'), 'refresh');
            return;
        }
        else {
            $this->session->set_flashdata('error', 'Password update failed.');
            redirect(site_url('alumni/account_settings'), 'refresh');
            return;
        }
    }
}