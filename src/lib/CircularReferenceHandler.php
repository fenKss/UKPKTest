<?php


namespace App\lib;


class CircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}