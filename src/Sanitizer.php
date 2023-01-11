<?php

namespace Vypsen\Sanitizer;

use Vypsen\Sanitizer\Filters\Integer;
use Vypsen\Sanitizer\Filters\RussianNumberPhone;
use Vypsen\Sanitizer\Interfaces\Filter;

class Sanitizer
{

    protected static function validation($value, Filter $filter)
    {
        if ($filter->validation($value)) return true;
        return $filter->errorMessageValid();
    }

    public static function applySanitizers($data, $filters)
    {
        $data = json_decode($data);
        $answer = [];
        if (count((array)$data) < count($filters))
        {
            return throw new \Exception('присутсвуют лишние фильтры');
        }

        foreach ($data as $key => $value)
        {
            $objectFilter = new $filters[$key];



            $valid = self::validation($value, $filters[$key]);
            if ($valid === true )
            {
                $answer[$key] = self::apply($value, $filters[$key]);
            } else {
                $answer[$key] = $valid;
            }
        }

        return $answer;
    }

    protected static function checkFilter(Filter $filter)
    {
        $objectFilter = new $filter;

        if ($objectFilter instanceof Filter) {
            return true;
        }
        return throw new \Exception('такого фильра нет');
    }

    protected static function apply($value, Filter $filter)
    {
        if (empty($filter))
        {
            return '';
        }

    }

}