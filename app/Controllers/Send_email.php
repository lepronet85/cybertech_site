<?php

namespace App\Controllers;

class Send_email extends BaseController
{
	public function index()
	{
        $name = $this->request->getPost('name');
        $from = $this->request->getPost('email');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');


        if ($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ])) 
        {

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

}
