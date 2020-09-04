<?php
declare(strict_types=1);

namespace App\Infrastructure\StringValidator;

class FloatValidator
{

    /** Float with max 4 decimals is allowed
     * @param string $floatString
     * @param bool $includeCommas
     * @return bool
     */
    public function hasFloatNumberStructure(string $floatString, bool $includeCommas = true)
    {

        if($includeCommas)
        $floatString = str_replace(',', '.', $floatString);

        return preg_match('/^[\d]{1,}(\.[\d]{1,4})?$/', $floatString) === 1;
    }


    public function isValidFloatNumber(string $floatString)
    {

        return is_numeric(floatval($floatString));

    }

}