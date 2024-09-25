<?php
namespace App\Models\Traits;

use ReflectionClass;

trait HasEnums
{
    public static function getEnums($type)
    {
        $constants = (new ReflectionClass(__CLASS__))->getConstants();
        $type = strtoupper($type);

        return array_values(
            array_filter($constants, function ($key) use ($type) {
                return str_starts_with($key, $type);
            }, ARRAY_FILTER_USE_KEY)
        );
    }
}