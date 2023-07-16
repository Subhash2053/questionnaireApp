<?php

namespace App\Services;

use App\Enums\Role;
use App\Mail\ExamMail;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private User $user)
    {

    }

    /**
     * Check If user credential is correct
     * @param array $data
     * @return mixed
     */
    public function checkUserCred($data)
    {
        $user = $this->user->where('email', $data['email'])
            ->where('role_id', Role::Student)
            ->first();

        $validCredentials = Hash::check($data['password'], $user->getAuthPassword());

        if ($validCredentials) {
            return $user;
        }
        throw new Exception('Incorrect Credential');

    }

}
