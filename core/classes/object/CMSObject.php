<?php

Autoloader::require("core/classes/object/CMSObjectHydration.php");

abstract class CMSObject extends CMSObjectHydration
{

    /**
     * @throws Exception
     */
    public function arrayToArray($array): array
    {
        $final_array = [];
        foreach ($array as $key => $value) {
            if (is_object($value)) {
                if (method_exists($value, "toArray")) {
                    $valueArray = $value->toArray();
                    if (is_string($key)) {
                        $final_array[$key] = $valueArray;
                    } else {
                        $final_array[] = $valueArray;
                    }
                    continue;
                }
                throw new Exception("toArray() function not found in $key");
            }
            if (is_array($value)) {
                $valueArray = arrayToArray($value);
                if (is_string($key)) {
                    $final_array[$key] = $valueArray;
                } else {
                    $final_array[] = $valueArray;
                }
                continue;
            }
            $this->$key = $value;
        }

        return $final_array;
    }

    /**
     * @throws Exception
     */
    public function toArray(): array
    {
        $array = [];

        foreach (get_object_vars($this) as $key => $value) {
            if (is_object($value)) {
                if (method_exists($value, "toArray")) {
                    $array[$key] = $value->toArray();
                    continue;
                }
                throw new Exception("toArray() function not found in $key");
            }
            if (is_array($value)) {
                $valueArray = $this->arrayToArray($value);
                $array[$key] = $valueArray;
                continue;
            }
            $array[$key] = $value;
        }
        return $array;
    }
}