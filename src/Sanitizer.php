<?php

namespace Vypsen\Sanitizer;

use Vypsen\Sanitizer\Filters\ArrayFilter;
use Vypsen\Sanitizer\Filters\FloatFilter;
use Vypsen\Sanitizer\Filters\IntegerFilter;
use Vypsen\Sanitizer\Filters\RussianNumberPhoneFilter;
use Vypsen\Sanitizer\Filters\StringFilter;
use Vypsen\Sanitizer\Filters\StructureFilter;
use Vypsen\Sanitizer\Interfaces\Filter;

class Sanitizer
{
    protected static $tegFilters = [
        'int' => IntegerFilter::class,
        'string' => StringFilter::class,
        'float' => FloatFilter::class,
        'ru_number_phone' => RussianNumberPhoneFilter::class,
        'array' => ArrayFilter::class,
        'structure' => StructureFilter::class,
    ];

    protected static function validation($value, $objectFilter)
    {
        if (self::existFilter($objectFilter))
        {
            if ($objectFilter->validation($value)) return true;
            return $objectFilter->errorMessageValid();
        }
        else {
            $name = $objectFilter::class;
            throw new \Exception("filter for value '{$value}' {$name} must be implements Vypsen\Sanitizer\Interfaces\Filter");
        }
    }

    public static function applySanitizers($data, $filters)
    {
        $answer = [];

        $data = json_decode($data);
        if (count((array)$data) < count($filters))
        {
            return throw new \Exception('there are extra filters');
        }

        foreach ($data as $key => $value)
        {
            if (array_key_exists($key, $filters))
            {
                $filter = self::parseFilter($filters[$key])[0];
                $option = self::parseFilter($filters[$key])[1];

                if (array_key_exists($filter, self::$tegFilters))
                {
                    $answer[$key] = self::apply($value, self::$tegFilters[$filter], $option);
                } else {
                    $answer[$key] = self::apply($value, $filter, $option);
                }
            } else  {
                $answer[$key] = $value;
            }
        }
        return $answer;
    }

    protected static function parseFilter($filters)
    {
        if (is_array($filters))
        {
            $filter = $filters[0];
            $option = $filters[1];
        } else {
            $filter = $filters;
            $option = null;
        }
        return [$filter, $option];
    }

    protected static function existFilter($objectFilter)
    {
        return ($objectFilter instanceof Filter);
    }

    protected static function apply($value, $filter, $option = null)
    {
        try {
            $objectFilter = new $filter;
        } catch (\Throwable $e) {
            return 'filter class not found';
        }

        $valid = self::validation($value, $objectFilter);
        if ($valid !== true) {
            return $valid;
        }
        return $objectFilter->sanitize($value, $option);
    }
}