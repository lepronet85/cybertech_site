<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    public function index()
    {
        return view('admin/sign_in');
    }

    public function dashbord()
    {
        return view('admin/dashbord');
    }
}