<?php

use App\Http\Controllers\Api\Controller;
use App\Mail\TestEmail;

class EmailsController extends Controller
{
    //Send Email
    /**
     * Display a listing of the users.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $email = ['message' => 'This is a test!'];
        Mail::to('anishkmathew@gmail.com')->send(new TestEmail($email));
    }

}
