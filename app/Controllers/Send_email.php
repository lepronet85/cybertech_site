<?php

namespace App\Controllers;

class Send_email extends BaseController
{
	public function index()
	{

        if ($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ])) 
        {

            $email = \Config\Services::email();

            $email->setFrom($this->request->getPost('email'), $this->request->getPost('name'));
            $email->setTo('abdoulazizsoumana85@gmail.com');

            $email->setSubject($email->request->getPost('subject'));
            $email->setMessage($email->request->getPost('message'));

            if ($email->send())
            {
                echo 'OK';
            }
   
        }
	}

}
