<?php

namespace common\components\helpers;

/**
 * Class helper for currency
 */
class CurrencyHelper
{
    /**
     * Format currency in rupiah
     *
     * @param string $number
     * @param bool $symbol
     * @return string currency or empty string
     */
    public static function rupiah($number, $symbol = true)
    {
        if (is_string($number)) {
            $currency = number_format($number, 2, ',', '.');
            return $symbol ? 'Rp. ' . $currency : $currency;
        }
        return '';
    }

    /**
     * @return string pattern
     */
    public static function patternRupiah()
    {
        return '/^(0|[1-9](?:\d{0,2}))(?:\.\d{3})*(?:\,\d{2})$/';
    }

    /**
     * @param string $value
     * @return string
     */
    public static function replaceComma($value)
    {
        return str_replace(',', '.', str_replace('.', '', $value));
    }

    /**
     * @param float $value
     * @return string
     */
    public static function reformatRupiah($value)
    {
        return sprintf('%0.2f', $value);
    }
}
