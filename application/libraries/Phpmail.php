<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Phpmail
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load() {
        $mail = new PHPMailer;
        return $mail;
    }
}  