<?php

class Contact extends Controller
{

    public function __construct()
    {
        //Check if user logged in, redirect to auth if not.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }
    public function index()
    {
        // DEBUG: Check what's in the session
        error_log("Session contents: " . print_r($_SESSION, true));

        // Pass user data to the view
        $userData = $_SESSION['user'];
        $barangay = $userData['barangay'] ?? 'Daanbantayan';

        //kuhaon ang barangay details gikan sa function nga getBarangayDetails()
        $barangayDetails  = $this->getBarangayDetails();
        $details = $barangayDetails[$barangay] ?? $barangayDetails['Daanbantayan'];

        //kuhaon ang value sa display message gikan sa contactForm() na function ug i assign sa variables
        $error = $_SESSION['contact_error'] ?? null;
        $success =  $_SESSION['contact_success'] ?? null;

        //i delete ang display message nga naa sa session
        unset($_SESSION['contact_error']);
        unset($_SESSION['contact_success']);

        $this->view('contact/index', [
            'user' => $userData,
            'barangayDetails' => $details,
            'error' => $error,
            'success' => $success
        ]);
    }

    //function for submitting contact form
    public function contactForm()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Gamiton ang session para makuha ang ID sa naka log in nga user
            $user = $_SESSION['user'];

            $data = [
                //sanitize the input
                'user_id' => htmlspecialchars(trim($user['id'])),
                'firstname' => htmlspecialchars(trim($_POST['firstname'])),
                'lastname' => htmlspecialchars(trim($_POST['lastname'])),
                'gmail' => filter_var(trim(strtolower($_POST['gmail'])), FILTER_SANITIZE_EMAIL),
                'phone' => htmlspecialchars(trim($_POST['phone'])),
                'message' => htmlspecialchars(trim($_POST['message']))
            ];

            //I validate ang form if naay value tanan input field
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['gmail'])  || empty($data['phone']) || empty($data['message'])) {
                $_SESSION['contact_error'] = 'All fields are required.';
                header('Location: ' . URL_ROOT . '/contact');
                exit;
            }

            //i validate ang email
            if (!filter_var($data['gmail'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['contact_error'] = 'Invalid email address';
                header('Location: ' . URL_ROOT . '/contact');
                exit;
            }

            //i validate ang phone number
            if (!preg_match('/^09[0-9]{9}$/', $data['phone'])) {
                $_SESSION['contact_error'] = 'Invalid phone number format. Must be 11 digits starting with 09.';
                header('Location: ' . URL_ROOT . '/contact');
                exit;
            }

            //pangitaon or i instantiate ang model para sendan sa data gikan sa input field
            $contactModel = $this->model('ContactModel');

            //i send and data sa input field padung sa model
            if ($contactModel->submitContact($data)) {
                $_SESSION['contact_success'] = 'Your message has been submitted successfully!';
            } else {
                $_SESSION['contact_error'] = 'Failed to submit your message. Please try again.';
            }

            header('Location: ' . URL_ROOT . '/contact');
            exit;
        }
    }

    private function  getBarangayDetails()
    {
        return [
            'Tapilon' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15651.496957973563!2d124.0207196321978!3d11.270653816586503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877cdf2f92c03%3A0x5ebd702f1c7dd656!2sTapilon%20Barangay%20Hall!5e0!3m2!1sen!2sph!4v1752040121515!5m2!1sen!2sph',
                'phone' => '(032)437-3765',
                'gmail' => 'brgy.tapilonofcl@gmail.com',
                'facebook' => 'https://web.facebook.com/profile.php?id=61554347493287',
                'fbName' => 'Barangay Tapilon'
            ],
            'Maya' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d500692.0165874774!2d123.24964129540528!3d11.359789817930817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877e775f573d1%3A0xb242f4fb38d59e!2sMaya%20Baranggay%20Hall!5e0!3m2!1sen!2sph!4v1752040254350!5m2!1sen!2sph',
                'phone' => '(032)340-18564',
                'gmail' => 'barangay_maya@yahoo.com',
                'facebook' => 'https://web.facebook.com/profile.php?id=61575813887580&rdid=DlYzM8MmGncDZ4a0&share_url=https%3A%2F%2Fweb.facebook.com%2Fshare%2F1FQXze85CH%2F%3F_rdc%3D1%26_rdr',
                'fbName' => 'Barangay Maya'
            ],
            'Poblacion' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7812.656272161509!2d123.99805230634198!3d11.253821989236988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877a0a270c489%3A0xf3c04035945accc0!2sBrgy.%20Poblacion%20Hall!5e0!3m2!1sen!2sph!4v1752040497088!5m2!1sen!2sph',
                'phone' => '(032)231-4525',
                'gmail' => 'pob.dbantayansec@gmail.com',
                'facebook' => 'https://web.facebook.com/skdbpoblacion',
                'fbName' => 'Barangay Poblacion'
            ],
            'Daanbantayan' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125220.84096790677!2d123.85405714335937!3d11.25027970000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a8770b5b923b63%3A0xe2cd86d84135f9ba!2sDaanbantayan%20Municipal%20Hall!5e0!3m2!1sen!2sph!4v1752043258401!5m2!1sen!2sph',
                'phone' => 'None',
                'gmail' => 'daanbantayan@gmail.com',
                'facebook' => '',
                'fbName' => 'Municipalty of Daanbantayan'
            ]
        ];
    }
}
