<?php

if(!function_exists('user_name')) {

    function user_name()
    {

        auth()->user()->name;
    }
}

    if(!function_exists('user_id')){

        function user_id(){

            auth()->user()->id;
        }


    }

if(!function_exists('user_email')) {

    function user_email()
    {

        auth()->user()->email;
    }
}
