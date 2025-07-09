<?php

class Contact extends Controller
{

    public function __construct()
    {
        session_start();

        //Check if user logged in, redirect to auth if not.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }
    public function index()
    {

        // Pass user data to the view
        $userData = $_SESSION['user'];
        $barangay = $userData['barangay'] ?? 'Daanbantayan';

        //Map URLs
        $mapUrls = [
            "Tapilon" => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15651.496957973563!2d124.0207196321978!3d11.270653816586503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877cdf2f92c03%3A0x5ebd702f1c7dd656!2sTapilon%20Barangay%20Hall!5e0!3m2!1sen!2sph!4v1752040121515!5m2!1sen!2sph",
            "Maya" => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d500692.0165874774!2d123.24964129540528!3d11.359789817930817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877e775f573d1%3A0xb242f4fb38d59e!2sMaya%20Baranggay%20Hall!5e0!3m2!1sen!2sph!4v1752040254350!5m2!1sen!2sph",
            "Poblacion" => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7812.656272161509!2d123.99805230634198!3d11.253821989236988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877a0a270c489%3A0xf3c04035945accc0!2sBrgy.%20Poblacion%20Hall!5e0!3m2!1sen!2sph!4v1752040497088!5m2!1sen!2sph",
            "Daanbantayan" => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125220.84096790677!2d123.85405714335937!3d11.25027970000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a8770b5b923b63%3A0xe2cd86d84135f9ba!2sDaanbantayan%20Municipal%20Hall!5e0!3m2!1sen!2sph!4v1752043258401!5m2!1sen!2sph",
        ];

        //prepare to be sent to UI
        $mapSrc = $mapUrls[$barangay] ?? $mapUrls['Daanbantayan'];

        $this->view('contact/index', [
            'user' => $userData,
            'mapSrc' => $mapSrc,
        ]);
    }
}
