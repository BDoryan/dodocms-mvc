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
    public static function sanitize($only, $array)
    {
        $flippedOnly = array_flip($only);
        return array_intersect_key($array, $flippedOnly);
    }

    public static function validatePassword($password)
    {
        /** @var ConfigurationFile $CMS_CONFIGURATION */
        global $CMS_CONFIGURATION;

        return (bool)preg_match($CMS_CONFIGURATION->get("password_policy"), $password);
    }
}