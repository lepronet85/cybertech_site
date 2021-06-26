<?php

namespace App\Controllers;

class GetQuote extends BaseController
{
    public function index () {

        $attachments = $this->request->getFile('attachments');
        $fileExt = strrchr($attachments->getName(), '.');
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar('phone');
        $from = $this->request->getVar('email');
        $to = 'abdoulazizsoumana85@gmail.com';
        $country = $this->request->getVar('country');
        $pack = $this->request->getVar('pack');
        $companyType = $this->request->getVar('companyType');
        $budget = $this->request->getVar('budget');
        $deadline = $this->request->getVar('deadline');
        $comments = $this->request->getVar('comments');

        $message = '<div>
                        <h1 style="text-align: center;">Demande de devis</h1>
                        <img src="assets/img/logo.jpg" alt="Logo CyberTech Niger" />
                        <h4>Nom : '.$name.'</h4>
                        <h4>Tel : '.$phone.'</h4>
                        <h4>Pays : '.$country.'</h4>
                        <h4>Type de compagnie : '.$companyType.'<h4>
                        <h4>Pack : '.$pack.'</h4>
                        <h4>Budget : '.$budget.'<h4>
                        <h4>Délai de lancement : '.$deadline.'<h4>
                        <div style="background-color: #d8dcdc; border: 2px solid #d8d0d0; padding: 8px;">
                            <p>'.$comments.'</p>
                        </div>
                    </div>';
        
        if (!$attachments->isValid())
        {
            throw new \RuntimeException($file->getErrorString().'('.$file->getError().')');
        } else {
            if (!file_exists(WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt))
            {
                $path = $attachments->store('tmp/', 'joinFile'.$fileExt);
            }
        }

        $email = \Config\Services::email();

        $email->setFrom($from, $name);
        $email->setTo($to);
        $email->attach(WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt);
        
        
        $email->setSubject('Demande de devis');
        $email->setMessage($message);
        
        if ($email->send())
        {
            if (file_exists(WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt)) {
				
				$success = unlink(WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt);
				
				if (!$success) {
					
					throw new Exception("Cannot delete ".WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt);
				
				}
			
			}
        }

    }
}