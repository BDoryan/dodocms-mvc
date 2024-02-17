<?php

class Validator
{
    public static function missingParameters(array $parameters, $from): bool
    {
        foreach ($parameters as $parameter)
            if (empty($from[$parameter]))
                return true;
        return false;
    }

    /**
     * Sanitize the key not needed
     *
     * @param $only
     * @param $array
     * @return array
     */
    public static function sanitize($only, $array): array
    {
        $flippedOnly = array_flip($only);
        return array_intersect_key($array, $flippedOnly);
    }

    public static function validatePassword($password): bool
    {
        return (bool)preg_match('/'.Application::get()->getConfiguration()["password_policy"].'/', $password);
    }
}