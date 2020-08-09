<?php

namespace Lengbin\Helper\Util;

class PasswordHelper
{

    /**
     * @param $originPassword
     *
     * @return false|string|null
     */
    public static function generatePassword($originPassword)
    {
        return password_hash($originPassword, PASSWORD_BCRYPT, [
            'cost' => 12,
        ]);
    }

    /**
     * @param $originPassword
     * @param $hashedPassword
     *
     * @return bool
     */
    public static function verifyPassword($originPassword, $hashedPassword)
    {
        return password_verify($originPassword, $hashedPassword);
    }
}
