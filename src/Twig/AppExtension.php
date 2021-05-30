<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('cast_to_array', [$this, 'castToArray']),
        ];
    }

    public function castToArray($array)
    {
        $response = array();
        foreach ($array as $key => $value) {
            $response[] = array($key, $value);
        }
        return $response;
    }
}