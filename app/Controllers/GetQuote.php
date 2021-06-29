<?php

namespace App\Controllers;

class GetQuote extends BaseController
{
    public function index () {

        $fileExt = '';
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar('phone');
        $from = $this->request->getVar('email');
        $to = 'abdoulazizsoumana85@gmail.com';
        $country = $this->request->getVar('country') != '' ? $this->request->getVar('country') : '';
        $pack = $this->request->getVar('pack') != 'Choisir' ? $this->request->getVar('pack') : '';
        $companyType = $this->request->getVar('companyType');
        $budget = $this->request->getVar('budget') != 'Choisir' ? $this->request->getVar('budget') : '';
        $deadline = $this->request->getVar('deadline') != '' ? $this->request->getVar('deadline') : '';
        $comments = $this->request->getVar('comments') != '' ? $this->request->getVar('comments') : '';

        $countryOut = $this->request->getVar('country') != '' ? '<h4>Pays : '.$country.'</h4>' : '';
        $packOut = $this->request->getVar('pack') != '' ? '<h4>Pack : '.$pack.'</h4>' : '';
        $budgetOut = $this->request->getVar('budget') != '' ? '<h4>Budget : '.$budget.'</h4>' : '';
        $deadlineOut = $this->request->getVar('deadline') != '' ? '<h4>Délai de lancement : '.$deadline.'</h4>' : '';
        $commentsOut = $this->request->getVar('comments') != '' ? '
            <div style="background-color: #d8dcdc; border: 2px solid #d8d0d0; padding: 8px;">
                <p>'.$comments.'</p>
            </div>
        ' : '';

        $message = '<div>
                        <h1 style="text-align: center;">Demande de devis</h1>
                        <img src="http://cybertechniger.com/assets/img/logo.jpg" alt="Logo CyberTech Niger" 
                        width="200"/>
                        <h4>Nom : '.$name.'</h4>
                        <h4>Tel : '.$phone.'</h4>
                        '.$countryOut.'
                        <h4>Type de compagnie : '.$companyType.'</h4>
                        '.$packOut.'
                        '.$budgetOut.'
                        '.$deadlineOut.'
                        '.$commentsOut.'
                    </div>';

        $email = \Config\Services::email();

        if (isset($_FILES['attachments'])) {
            $attachments = $this->request->getFile('attachments');
            if ($attachments->isValid()) {
                $fileExt = strrchr($attachments->getName(), '.');
                if (!file_exists(WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt))
                {
                    $path = $attachments->store('tmp/', 'joinFile'.$fileExt);
                }
            }

            $email->attach(WRITEPATH.'uploads/tmp/'.'joinFile'.$fileExt);
        }

        $email->setFrom($from, $name);
        $email->setTo($to);
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

            echo "OK";
        } else {
            echo "L'email n'a pas été envoyé, désolé";
        }

    }
}