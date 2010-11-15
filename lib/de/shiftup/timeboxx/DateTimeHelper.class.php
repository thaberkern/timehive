<?php
/**
 * Description of DateTimeHelper
 *
 * @author thaberkern
 */
class DateTimeHelper
{
    public static function create()
    {
        return new DateTimeHelper();
    }

    public function getDaysOfWeek($week_number, $year)
    {
        $result = array();
        for($day=1; $day<=7; $day++) {
            $timestamp = strtotime($year."W".str_pad($week_number,2,'0',STR_PAD_LEFT).$day);

            $result[$day] = $timestamp;
        }

        return $result;
    }
}
