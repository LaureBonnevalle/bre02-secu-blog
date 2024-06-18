<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CSRFTokenManager
{//genere un token 
    public function generateCSRFToken() : string
    {
        $token = bin2hex(random_bytes(32));

        return $token;
    }
// verifie un token
    public function validateCSRFToken($token) : bool
    {

        if (isset($_SESSION['csrf-token']) && hash_equals($_SESSION['csrf-token'], $token))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}