<?php

namespace App\Traits;

trait ValidateTrait {

    public function cleanInput($input)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->cleanInput($value);
            }
        } elseif (!is_null($input)) {
            $input = preg_replace('/<\/?[^>]+(>|$)/', '', $input); 
            $input = preg_replace('/\s+/', ' ', $input); 
            $input = trim($input); 

            $input = str_replace(['"', "'", "`"], '', $input);
        }
        return $input;
    }
}
