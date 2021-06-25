<?php

namespace App\Controllers;

class Send_email extends BaseController
{
	public function index()
	{
        $name = $this->request->getVar('name');
        $from = $this->request->getVar('email');
        $subject = $this->request->getVar('subject');
        $message = $this->request->getVar('message');
        
        $email = \Config\Services::email();

        $email->setFrom($from, $name);
        $email->setTo('abdoulazizsoumana85@gmail.com');
        
        
        $email->setSubject($subject);
        $email->setMessage($message);
        
        if ($email->send())
        {
            echo 'OK';
        }
	}

}
