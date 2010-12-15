<?php

class TimeItemSelector
{

    public function __construct($time_items)
    {
        $this->time_items = array();

        foreach ($time_items as $time_item) {
            $this->time_items[$time_item->project_id][$time_item->itemdate][] = $time_item;
        }
    }

    public function find($project_id, $booking_date)
    {
        $result = array();

        if (array_key_exists($project_id, $this->time_items) &&
                array_key_exists(date("Y-m-d", $booking_date), $this->time_items[$project_id])) {
            $values = $this->time_items[$project_id][date("Y-m-d", $booking_date)];
            if ($values) {
                return $values;
            }
            else {
                return array(null);
            }
        }

        return $result;
    }

    public function findOne($project_id, $booking_date)
    {
        $all = $this->find($project_id, $booking_date);

        if (sizeof($all) == 0) {
            return null;
        }
        return $all[0];
    }

    private $time_items;

}