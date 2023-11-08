<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use SMTPValidateEmail\Validator as SmtpEmailValidator;

class Email_validation
{
    public function __construct() {
        log_message('Debug', 'SMTPEmailValidator class is loaded.');
    }

    public function check($email, $sender) {
        $result = array();
        $validator = new SmtpEmailValidator($email, $sender);

        // If debug mode is turned on, logged data is printed as it happens:
        // $validator->debug = true;
        $data = $validator->validate();

        if ($data[$email]) 
        {
            $result['value'] = TRUE;
            $result['domains'] = $data['domains'];
            $result['logs'] = $validator->getLog();
        }
        else
        {
            $result['value'] = FALSE;
            $result['domains'] = $data['domains'];
            $result['logs'] = $validator->getLog();
        }

        return $result;
    }
}