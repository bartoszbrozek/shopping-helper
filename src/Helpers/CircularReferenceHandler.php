<?php

namespace App\Helpers;

class CircularReferenceHandler
{

    public function __invoke($object)
    {
        return $object->getId();
    }
}
