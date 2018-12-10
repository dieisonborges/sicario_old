<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class ForgotPasswordController extends Controller
{

    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="ForgotPasswordController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/


    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //LOG ----------------------------------------------------------------------------------------
        $this->log("recuperarSenha");
        //--------------------------------------------------------------------------------------------
        
        $this->middleware('guest');
    }
}
