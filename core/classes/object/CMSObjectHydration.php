<?php

abstract class CMSObjectHydration
{

    /**
     * @throws Exception
     */
    public function hydrate(array $data): void
    {
       foreach ($data as $key => $value) {
            $methodName = 'set' . Tools::underscoreToCamelCase($key);
            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            } else {
                throw new Exception("Method $methodName does not exist");
            }
        }
    }
}