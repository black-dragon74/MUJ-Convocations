<?php
defined('BASEPATH') or exit('Direct access not allowed');

// Composer autoloader
require_once FCPATH.'vendor/autoload.php';

// PppSpreadsheet objects
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Admin extends CI_Controller {

    /**
     * Constructor override
     */
    public function __construct()
    {
        parent::__construct();

        // Load the helper
        $this->load->helper('convocation');

        // Put intruders to the curb
        $this->adminOrGTFO();
    }

    /**
     * I tell intruders to fuck off
     */
    public function adminOrGTFO() {
        if ($this->session->userdata('admin_login') != '1') {
            redirectError($this, 'You must login first', 'login');
        }
    }

    /**
     * Index function
     */
    public function index() {
        $data['title'] = 'Dashboard';
        $data['username'] = 'Nick';

        // Now fetch the user details
        $users = $this->db->get('users')->num_rows();
        $confirmed = $this->db->get_where('users', array('confirmed' => '1'))->num_rows();
        $attending = $this->db->get_where('users', array('formtype' => '0'))->num_rows();
        $parents = $this->db->get_where('users', array('parents' => '1'))->num_rows();
        $post = $this->db->get_where('users', array('formtype' => '1'))->num_rows();
        $unpaid = $this->db->get_where('users', array('paid' => '0'))->num_rows();
        $paid = $this->db->get_where('users', array('paid' => '1'))->num_rows();

        // Fetch the event days
        $sql = 'select value from event_days order by id DESC LIMIT 1';
        $lastDate = $this->db->query($sql)->row();
        if ($lastDate) {
            $lastDate = $lastDate->value;
        }

        $sql = 'select value from event_days order by id ASC LIMIT 1';
        $startDate = $this->db->query($sql)->row();
        if ($startDate) {
            $startDate = $startDate->value;
        }

        $eventArray = array();
        $events = $this->db->get_where('event_days', array('disabled' => '0'));  // Only the dates that are not disabled.
        if ($events) {
            $array = $events->result_array();
            foreach ($array as $ar) {
                array_push($eventArray, $ar);
            }
        }

        // Put the data in the payload
        $data['users'] = $users;
        $data['confirmed'] = $confirmed;
        $data['attending'] = $attending;
        $data['parents'] = $parents;
        $data['post'] = $post;
        $data['unpaid'] = $unpaid;
        $data['paid'] = $paid;

        // Update dates only if there is some value in the database
        if (!empty($startDate) && !empty($lastDate)) {
            $data['startDate'] = $startDate;
            $data['lastDate'] = $lastDate;
        }

        // Update the days
        if (count($eventArray) > 0) {
            $data['events'] = $eventArray;
        }

        // Load the view with the data
        $this->load->view('admin/dashboard', $data);
    }

    /**
     * I generate the template for the document upload
     */
    public function gen_xlsx() {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();

        // The below methods might throw, hence they are in a try and catch block
        try {
            // Insert the values
            $spreadsheet->setActiveSheetIndex(0)    // Should not have more than 1 sheet anyways!
                ->setCellValue('A1', 'Name')
                ->setCellValue('B1', 'RegNo')
                ->setCellValue('C1', 'Email')
                ->setCellValue('D1', 'Contact')
                ->setCellValue('E1', 'GPA')
                ->setCellValue('F1', 'DOB')
                ->setCellValue('G1', 'Program')
                ->setCellValue('H1', 'School')
                ->setCellValue('I1', 'Department')
                ->setCellValue('J1', 'Address');

            // Set a few properties on the spreadsheet
            $spreadsheet->getProperties()
                ->setCreator('Nick')
                ->setSubject('Upload Template')
                ->setDescription('An Excel format for uploading data to MUJ Convocations portal');

            // Set the doc title
            $spreadsheet->getActiveSheet()->setTitle('template');

            // Crete a new writer object
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            // Tell the browser to expect a Excel format response
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="template.xlsx"');
            header('Cache-Control: max-age=0');

            // Throw the file back to the browser and we are done
            $writer->save('php://output');
        }
        // You may try your best but shit can happen anytime, hence catch that bullshit
        catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            $this->session->set_flashdata('error', 'Unable to generate the template.');
            redirect(site_url('admin'), 'refresh');
        }
    }

    /**
     * I process the uploaded excel file and insert the data in the DB
     */
    public function process_data() {
        // We only accept the Xlsx format
        $file_mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        // Check if the file is uploaded and has the .xlsx file type
        if(isset($_FILES['data-file']['name']) && $_FILES['data-file']['type'] == $file_mime) {

            // Store the file name on the server in a var
            $uploadedFile = $_FILES['data-file']['tmp_name'];

            // Below operation might throw
            try {
                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($uploadedFile);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $success = 0;
                $error = 0;

                foreach ($sheetData as $key => $value) {
                    // Ignore the headers
                    if ($key != '0') {
                        // Create a payload
                        $payload = array();
                        $payload['name'] = $value['0'];
                        $payload['regno'] = $value['1'];
                        $payload['email'] = $value['2'];
                        $payload['mobile'] = $value['3'];
                        $payload['gpa'] = $value['4'];
                        $payload['dob'] = $value['5'];
                        $payload['programme'] = $value['6'];
                        $payload['school'] = $value['7'];
                        $payload['department'] = $value['8'];
                        $payload['address'] = $value['9'];

                        // Attempt to insert in the DB
                        $inserted = $this->db->insert('alumni', $payload);

                        // Keep updating the counters
                        if ($inserted) {
                            $success++;
                        }
                        else {
                            $error++;
                        }
                    }
                }

                // Well, thank god now that loop is complete. Let's check if we succeeded or failed.
                if ($error > 0) {
                    if ($success > 0) {
                        // We have error and success too
                        $message = 'Processing complete. '.$success. ' successful. '.$error.' failed.';
                        redirectSuccess($this, $message, 'admin');
                    }

                    if ($success == 0) {
                        // We have errors only
                        $message = 'Processing complete. '.$error.' failed.';
                        redirectError($this, $message, 'admin');
                    }
                }
                else {
                    // Well, this is nice, 100% success
                    $message = 'Processing complete. '.$success.' successful.';
                    redirectSuccess($this, $message, 'admin');
                }
            }
            catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                redirectError($this, 'Unable to read the uploaded file.', 'admin');
            }
        }
        else {
            redirectError($this, 'Invalid file uploaded', 'admin');
        }
    }

    /**
     * I get details for an user and return a JSON object for parsing back in the DOM
     * Note that this function should always return values in JSON format else website will fuck itself up
     */
    public function ajax_get_user() {
        // Verify that the AJAX is valid
        if (!isset($_POST['convo_ajax'])) {
            echo json_encode(array('error' => 'Unauthorized access thawed'));
            return;
        }

        // Get the user name
        $regno = $this->input->post('regno');

        // If empty, return
        if (empty($regno)) {
            echo json_encode(array('error' => 'Unable to get registration number'));
            return;
        }

        // Get the user details from the database
        $user = $this->db->get_where('alumni', array('regno' => $regno));

        // If user not in DB, return
        if ($user->num_rows() == 0) {
            echo json_encode(array('error' => 'Alumni not found for '.$regno));
            return;
        }
        else {
            // Send the Data back in JSON format
            echo json_encode($user->row());
            return;
        }
    }

    /**
     * I update the records of existing student
     */
    public function update_student() {
        // Extract the values from the request
        $regno = $this->input->post('regno');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $altMobile = $this->input->post('alt-mobile');
        $programme = $this->input->post('faculty');
        $school = $this->input->post('school');
        $dept = $this->input->post('dept');
        $dob = $this->input->post('dob');

        // First check if the user really exists
        $userExists = $this->db->get_where('alumni', array('regno' => $regno))->row();

        if (!$userExists) {
            $this->session->set_flashdata('error', 'User not found');
            redirect(site_url('admin'), 'refresh');
            return;
        }

        // Else, we update in the DB
        $this->db->where('regno', $regno);
        $updated = $this->db->update('alumni', array(
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'alt_mobile' => $altMobile,
            'programme' => $programme,
            'school' => $school,
            'department' => $dept,
            'dob' => $dob
        ));

        if ($updated) {
            $this->session->set_flashdata('success', 'Data updated successfully!');
            redirect(site_url('admin'), 'refresh');
        }
        else {
            $this->session->set_flashdata('error', 'Unable to update the user details.');
            redirect(site_url('admin'), 'refresh');
        }
    }

    /**
     * I add the admin user
     */
    public function add_admin() {
        $name = $this->input->post('admin-name');
        $email = $this->input->post('admin-email');
        $password = $this->input->post('admin-password');

        // If anything is empty, back to square one.
        if (empty($name) || empty($email) || empty($password)) {
            die();
        }

        $exist = $this->db->get_where('admin', array('username' => $email))->num_rows();

        if ($exist > 0) {
            redirectError($this, 'User already exits', 'admin');
            return;
        }

        // Else, hash the password
        $securePassword = password_hash($password, PASSWORD_BCRYPT);

        $adminAdded = $this->db->insert('admin', array(
            'name' => $name,
            'username' => $email,
            'password' => $securePassword
        ));

        if ($adminAdded) {
            redirectSuccess($this, 'User added successfully', 'admin');
        }
        else {
            redirectError($this, 'Unable to add user', 'admin');
        }
    }

    /**
     * This function updates the event days in the database
     */
    public function update_event_days() {
        // Get the values from the HTML form
        $startDate = $this->input->post('start-date');
        $endDate = $this->input->post('end-date');

        // Well, here you go!
        if (empty($startDate) || empty($endDate)) {
            die();
        }

        // Now comes the real headache, find the difference
        // We will convert both to time then minus start from end.
        // Then we will didvide the value we get in seconds by (60 * 60 * 24) to get value in days
        $startTime = strtotime($startDate);
        $endTime = strtotime($endDate);

        // Until here, we have the values in days!
        $days = ($endTime - $startTime) / (60 * 60 * 24);

        // For each day, we have a new entry in the database, but before that we empty the database
        $this->db->truncate('event_days');
        $startCounter = $startTime; // We will keep addings days to it
        for ($i = 0; $i <= $days; $i++) {

            // Create the payload for the DB
            $payload = array();
            $payload['name'] = 'Day '. ($i + 1);
            $payload['value'] = date('d-m-Y', $startCounter);
            $payload['disabled'] = '0';

            // Increment the day in a special way. We will add one day
            $startCounter += (24 * 60 * 60);

            // Insert into the DB
            $updated = $this->db->insert('event_days', $payload);
        }

        if ($updated) {
            redirectSuccess($this, 'Event days updated successfully.', 'admin');
        }
        else {
            redirectError($this, 'Unable to update event days', 'admin');
        }
    }

    /**
     * I lock and unlock the event dates
     */
    public function lock_event_days() {
        // Get the value from the form post
        $disabledDates = $this->input->post('disable-dates');

        // Guard
        if (empty($disabledDates)) {
            die();
        }

        // For each date, update the same in the DB
        foreach ($disabledDates as $date) {
            $this->db->where('value', $date);
            $result = $this->db->update('event_days', array(
                'disabled' => '1'
            ));
        }

        if ($result) {
            redirectSuccess($this, 'Dates disabled successfully', 'admin');
        }
        else {
            redirectError($this, 'Unable to disabled selected dates', 'admin');
        }
    }

    /**
     * I take care of managing the live state of the portal
     */
    public function update_state() {
        $val = $this->input->post('site-offline');

        if (empty($val)) {
            die();
        }

        $siteOffline = $val == 'yes' ? '1' : '0';

        $updated = setConfig($this, 'site_offline', $siteOffline);

        if ($updated) {
            redirectSuccess($this, 'Site active state changed', 'admin');
        }
        else {
            redirectError($this, 'Unable to update site state', 'admin');
        }
    }

    /**
     * I reset password for the alumni
     */
    public function reset_alumni() {
        $regno = $this->input->post('reg-no');

        if (empty($regno)) {
            die();
        }

        $exist = $this->db->get_where('users', array('regno' => $regno))->num_rows();

        if ($exist == 0) {
            redirectError($this, 'User not found', 'admin');
            return;
        }

        $this->db->where('regno', $regno);

        $result = $this->db->update('users', array(
            'password' => password_hash('123', PASSWORD_BCRYPT)
        ));

        if ($result) {
            redirectSuccess($this, 'Password reset to: 123', 'admin');
        }
        else {
            redirectError($this, 'Failed to reset the password', 'admin');
        }
    }

    /**
     * I reset password for the admin
     */
    public function reset_admin() {
        $email = $this->input->post('admin-email');

        if (empty($email)) {
            die();
        }

        $exist = $this->db->get_where('admin', array('username' => $email))->num_rows();

        if ($exist == 0) {
            redirectError($this, 'User not found', 'admin');
            return;
        }

        $this->db->where('username', $email);

        $result = $this->db->update('admin', array(
            'password' => password_hash('123', PASSWORD_BCRYPT)
        ));

        if ($result) {
            redirectSuccess($this, 'Password reset to: 123', 'admin');
        }
        else {
            redirectError($this, 'Failed to reset the password', 'admin');
        }
    }

    /**
     * Function to handle the event fee related changes
     */
    public function update_fees() {
        var_dump($_POST);

        $eventType = $this->input->post('event-type');
        $eventPrice = $this->input->post('event-price');

        if (empty($eventPrice) || empty($eventType)) {
            die();
        }
        $success = false;

        switch ($eventType) {
            case 'attend':
                $success = setConfig($this, 'attend_fee', $eventPrice);
                break;
            case 'post':
                $success = setConfig($this, 'post_fee', $eventPrice);
                break;
            default:
                break;
        }

        $success
            ?
            redirectSuccess($this, 'Event fees updated successfully.', 'admin')
            :
            redirectError($this, 'Unable to update event fees', 'admin');
    }

    /**
     * Function to admit a student manually
     */
    public function add_student_manually() {
        // Get the values form the POST payload
        $regNo = $this->input->post('reg_no');
        $name = $this->input->post('alumni_name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('phone');
        $gpa = $this->input->post('gpa');
        $dob = $this->input->post('dob');
        $program = $this->input->post('program');
        $school = $this->input->post('school');
        $dept = $this->input->post('dept');
        $address = $this->input->post('address');

        // Sanity check for the required fields
        if (!isset($regNo) || !isset($name) || !isset($email) || !isset($mobile)) {
            redirectError($this, 'Invalid form submitted.', 'admin');
        }

        // Else create the payload for the database
        $payload = array(
            'regno' => $regNo,
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'gpa' => $gpa,
            'dob' => $dob,
            'programme' => $program,
            'school' => $school,
            'department' => $dept,
            'address' => $address
        );

        // Insert the data in the DB
        $inserted = $this->db->insert('alumni', $payload);

        $inserted
            ?
            redirectSuccess($this, 'Student added successfully', 'admin')
            :
            redirectError($this, 'Unable to add the student', 'admin');
    }

    /**
     * Loads the frontend editor
     */
    public function frontend_editor()
    {
        $data['title'] = 'Frontend Editor';
        $this->load->view('admin/frontend_editor', $data);
    }

    /**
     * handles actual updation of the home page
     */
    public function update_home()
    {
        $homeContent = $this->input->post('home');

        if (!isset($homeContent)) {
            return;
        }

        // Else update the DB
        $this->db->where('name', 'home');
        $updated = $this->db->update('html_content', array('content' => $homeContent));

        if ($updated) {
            redirectSuccess($this, 'Page content updated successfully', 'admin/frontend_editor');
        }
        else {
            redirectError($this, 'Page content updation failed', 'admin/frontend_editor');
        }
    }

    /**
     * handles actual updation of the guidelines page
     */
    public function update_guidelines()
    {
        $homeContent = $this->input->post('guidelines');

        if (!isset($homeContent)) {
            return;
        }

        // Else update the DB
        $this->db->where('name', 'guidelines');
        $updated = $this->db->update('html_content', array('content' => $homeContent));

        if ($updated) {
            redirectSuccess($this, 'Page content updated successfully', 'admin/frontend_editor');
        }
        else {
            redirectError($this, 'Page content updation failed', 'admin/frontend_editor');
        }
    }

    /**
     * handles actual updation of the instructions page
     */
    public function update_instructions()
    {
        $homeContent = $this->input->post('instructions');

        if (!isset($homeContent)) {
            return;
        }

        // Else update the DB
        $this->db->where('name', 'instructions');
        $updated = $this->db->update('html_content', array('content' => $homeContent));

        if ($updated) {
            redirectSuccess($this, 'Page content updated successfully', 'admin/frontend_editor');
        }
        else {
            redirectError($this, 'Page content updation failed', 'admin/frontend_editor');
        }
    }

    /**
     * handles actual updation of the contact page
     */
    public function update_contact()
    {
        $homeContent = $this->input->post('contact');

        if (!isset($homeContent)) {
            return;
        }

        // Else update the DB
        $this->db->where('name', 'contact');
        $updated = $this->db->update('html_content', array('content' => $homeContent));

        if ($updated) {
            redirectSuccess($this, 'Page content updated successfully', 'admin/frontend_editor');
        }
        else {
            redirectError($this, 'Page content updation failed', 'admin/frontend_editor');
        }
    }
}