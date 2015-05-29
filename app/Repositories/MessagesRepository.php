<?php namespace App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MessagesRepository{

    private $fields= [];

//    public function __construct(Array $fields){
//        $this->fields = $fields;
//    }

    /**
     * Send message if the User successful created.
     */
    public function messageUserCreated(){
//        dd(trans('email.userCreatedSubject'));
        return Mail::send('emails.userCreated', $this->fields, function($message) {
            $message->to($this->fields['email'], $this->fields['name'])->subject(trans('email.userCreatedSubject'));
        });
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
}