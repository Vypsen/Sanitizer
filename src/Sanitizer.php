<?php

namespace Vypsen\Sanitizer;

use Vypsen\Sanitizer\Filters\ArrayFilter;
use Vypsen\Sanitizer\Filters\FloatFilter;
use Vypsen\Sanitizer\Filters\Integer;
use Vypsen\Sanitizer\Filters\RussianNumberPhone;
use Vypsen\Sanitizer\Filters\StringFilter;
use Vypsen\Sanitizer\Interfaces\Filter;

class Sanitizer
{
    protected static $tegFilters = [
        'int' => Integer::class,
        'string' => StringFilter::class,
        'float' => FloatFilter::class,
        'ru_number_phone' => RussianNumberPhone::class,
        'array' => ArrayFilter::class,
    ];

    protected static function validation($value, $filter)
    {
        if (self::existFilter($filter))
        {
            if ($filter->validation($value)) return true;
            return $filter->errorMessageValid();
        }
        else {
            $nameClass = $filter::class;
            throw new \Exception("{$nameClass} must be implements Vypsen\Sanitizer\Interfaces\Filter");
        }
    }

    public static function applySanitizers($data, $filters)
    {
        $data = json_decode($data);
        $answer = [];
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
                }
            } else {
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
    protected static function existFilter($filter)
    {
        if (!($filter instanceof Filter) || empty($filter)) {
            return false;
        }
        return true;
    }

    protected static function apply($value, $filter, $option)
    {
        $objectFilter = new $filter;
        $valid = self::validation($value, $objectFilter);
        if ($valid !== true) {
            return $valid;
        }
        return $objectFilter->sanitize($value, $option);
    }
}