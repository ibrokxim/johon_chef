<?php

namespace App\Actions;

class PhoneValidateAction
{
    public function handle($phone): bool
    {
        if(preg_match('/^\+[0-9]{12}+$/', $phone) || preg_match('/^[0-9]{13}+$/', $phone)) {
            return true;
        }

        return false;
    }
}