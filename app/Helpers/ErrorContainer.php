<?php

namespace App\Helpers;

 class ErrorContainer
 {
    public static function errorValidator($validator){
        $errKeeper = [];
        foreach($validator->errors()->getMessages() as $index => $error){
            array_push($errKeeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $errKeeper;
    }
 }
