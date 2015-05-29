<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 14/04/15
 * Time: 02:30
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Mail;
//use \Illuminate\Mail\Mailer as Mail;
use Illuminate\Validation\Validator;

class FooRepository {
    public function get() {
        //$ret = new \App\Models\OldOrder;
        $mail = Mail::send('emails.welcome', array(), function($message) {
            $message->to('luciano.bapo@gmail.com', 'Jon Doe')->subject('Welcome to the Laravel 4 Auth App!');
        });
        $mail = Mail::failures();
        dd($mail);
        //\Illuminate\Html\FormBuilder::hasMacro()
//        Validator::make();
        //return $ret->listar();
        //return ['array', 'of'];

    }
}