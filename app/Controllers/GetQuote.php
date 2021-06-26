<?php

namespace App\Controllers;

class GetQuote extends BaseController
{
    public function index () {

        echo $this->request->getFiles();

    }
}