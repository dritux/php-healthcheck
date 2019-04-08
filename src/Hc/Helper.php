<?php
namespace Dr\Hc;

class Helper
{
    public static function toObject($data)
    {
        return is_array($data) ? (object) array_map(__METHOD__, $data) : $data;
    }
}
