<?php

namespace App\Actions;

use App\Models\User;

class UserUpdateStepAction
{
    public function update(User $user, string $step)
    {
        $user->update([
            'step' => $step
        ]);
    }
}