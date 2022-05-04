<?php

namespace App\Helpers;

class NameHelper
{
    public static function makeNameUrlFriendly(string $name) : string
    {
        return str_replace(' ', '-', strtolower($name));
    }
}