<?php

class util extends \framework\LibBase {

    function randomstring($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function masking($_data){
        $_data = str_replace('-','',$_data);
        $strlen = mb_strlen($_data, 'utf-8');

        $size = round($strlen / 3);
        if ( $size == 0 ) $size = 1;
    
        $name = mb_substr($_data, 0, $size);

        for ( $i = 0 ; $i < $strlen - $size ; $i++ ) 
            $name = $name . "*";

        return $name;
    }

}
