<?php

namespace common\components\helpers;

use Yii;

/**
 * Class helper for Date and Time
 */
class DateTimeHelper
{
    /**
     * Format date
     *
     * @param string date
     * @param string format date
     * @param bool $micro
     * @return string date formatted
     */
    public static function formatDate($date, $format = 'd-m-Y', $micro = false)
    {
        $formatedDate = '';
        if (!empty($date)) {
            $date = $micro ? $date : strtotime($date);
            $formatedDate = date($format, $date);
        }
        return $formatedDate;
    }

    /**
     * Format date in short `indonesia` format
     *
     * @param string date
     * @param bool $micro
     * @return string date formatted
     */
    public static function shortDateIna($date, $micro = false)
    {
        $dateIna = self::formatDate($date, 'd-m-Y', $micro);
        return $dateIna;
    }

    /**
     * @return array month
     */
    public static function getListMonthShort()
    {
        $months = [
            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];
        return $months;
    }

    /**
     *
     */
    public static function getItemDate($date, $micro = false)
    {
        if (empty($date)) {
            return '';
        }
        $months = self::getListMonthShort();
        $lmonths = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
            'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $days = [
            1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
        ];
        if (!$micro) {
            $date = strtotime($date);
        }
        $dateIna = [];
        $dateIna['d'] = date('d', $date);
        $dateIna['m'] = date('m', $date);
        $dateIna['n'] = $months[date('n', $date)];
        $dateIna['ln'] = $lmonths[date('n', $date)];
        $dateIna['Y'] = date('Y', $date);
        $dateIna['N'] = $days[date('N', $date)];
        $dateIna['H:i:s'] = date('H:i:s', $date);
        return $dateIna;
    }

    /**
     * Format date in long `indonesia` format
     *
     * @param string date
     * @param bool $micro
     * @return string date formatted
     */
    public static function longDateIna($date, $micro = false)
    {
        if (empty($date)) {
            return '';
        }
        $dateIna = self::getItemDate($date, $micro);
        return implode(" ", [$dateIna['d'], $dateIna['n'], $dateIna['Y']]);
    }

    /**
     * Format date in long `indonesia` format
     *
     * @param string date
     * @param bool $micro
     * @return string date formatted
     */
    public static function longMonthDateIna($date, $micro = false)
    {
        if (empty($date)) {
            return '';
        }
        $dateIna = self::getItemDate($date, $micro);
        return implode(" ", [$dateIna['d'], $dateIna['ln'], $dateIna['Y']]);
    }

    /**
     * Format date in long `indonesia` format with day names
     *
     * @param string date
     * @param bool $micro
     * @return string date formatted
     */
    public static function longDayDateIna($date, $micro = false)
    {
        if (empty($date)) {
            return '';
        }
        $dateIna = self::getItemDate($date, $micro);
        return $dateIna['N'] . ", " . implode(" ", [$dateIna['d'], $dateIna['n'], $dateIna['Y']]);
    }

    /**
     * Format date in long `indonesia` format with day names
     *
     * @param string date
     * @param bool $micro
     * @return string date formatted
     */
    public static function longDayDateTimeIna($date, $micro = false)
    {
        if (empty($date)) {
            return '';
        }
        $dateIna = self::getItemDate($date, $micro);
        return $dateIna['N'] . ", " . implode(" ", [$dateIna['d'], $dateIna['n'], $dateIna['Y']]) .
               " " . $dateIna['H:i:s'];
    }

    /**
     * Format date and time in short `indonesia` format
     *
     * @param string date
     * @param bool $micro
     * @return string date formatted
     */
    public static function shortDateTimeIna($date, $micro = false)
    {
        $dateIna = self::formatDate($date, 'd-m-Y H:i:s', $micro);
        return $dateIna;
    }

    /**
     * @param string date
     * @link https://www.w3schools.in/php-script/time-ago-function/
     */
    public static function timeAgo($date, $micro = false)
    {
        if (empty($date)) {
            return '';
        }
        $time = $micro ? $date : strtotime($date);
        $time_difference = time() - $time;

        if( $time_difference < 1 ) {
            return 'less than 1 second';
        }
        $condition = [
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        foreach ($condition as $secs => $str)
        {
            $d = $time_difference / $secs;
            if ( $d >= 1 )
            {
                $t = round($d);
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' );
            }
        }
    }

    /**
     * Base method get diff date
     */
    public static function baseDiff($date1, $date2, $format = 'd-m-Y')
    {
        $date1 = \DateTime::createFromFormat($format, $date1);
        $date2 = \DateTime::createFromFormat($format, $date2);
        $diff = $date1->diff($date2);
        return $diff;
    }

    /**
     * Get number of months
     *
     * @param string $date1 must be formatted `d-m-Y`
     * @param string $date2 must be formatted `d-m-Y`
     * @return int month
     */
    public static function diffInMonths($date1, $date2)
    {
        $diff = self::baseDiff($date1, $date2);
        $months = ($diff->y * 12) + $diff->m + ($diff->d / 30);
        return (int) round($months);
    }

    /**
     * Get number of days
     *
     * @param string $date1 must be formatted `d-m-Y`
     * @param string $date2 must be formatted `d-m-Y`
     * @return int day
     */
    public static function diffInDays($date1, $date2)
    {
        $diff = self::baseDiff($date1, $date2);
        return $diff->days;
    }

    /**
     * Get diff date
     *
     * @param string $date1 must be formatted `d-m-Y`
     * @return int month
     */
    public static function diffDateNow($date1)
    {
        $dateNow = date('d-m-Y');
        $diff = self::baseDiff($date1, $dateNow);
        $result = Yii::t('app', '{year} years {month} months {day} days', [
            'year' => $diff->y,
            'month' => $diff->m,
            'day' => $diff->d
        ]);
        return $result;
    }

    /**
     * Get diff date years
     *
     * @param string $date1 must be formatted `d-m-Y`
     * @return int month
     */
    public static function diffYearNow($date1)
    {
        $dateNow = date('d-m-Y');
        $diff = self::baseDiff($date1, $dateNow);
        return $diff->y;
    }
}
