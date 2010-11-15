<?php
function week_number($day)
{
    return date('W', strtotime($day));
}
