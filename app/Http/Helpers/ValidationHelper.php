<?php 




class ValidationHelper
{


    function cleanInput($input)
    {
        $input = preg_replace('/<\/?[^>]+(>|$)/', '', $input);
        $input = preg_replace('/\s+/', ' ', $input);
        return trim($input);
    }



}