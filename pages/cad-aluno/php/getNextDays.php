<?php
function getNextDaysOfWeek($daysArray, $startDate, $endDate)
{
    $dayMap = [
        "segunda" => 1,
        "terça" => 2,
        "quarta" => 3,
        "quinta" => 4,
        "sexta" => 5,
    ];

    $result = [];
    $daysOfWeekNumbers = array_map(fn($day) => $dayMap[strtolower($day)], $daysArray);

    $nextDay = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    while ($nextDay <= $endDate) {
        if (in_array((int) $nextDay->format('N'), $daysOfWeekNumbers)) {
            $result[] = $nextDay->format('d/m/Y');
        }
        $nextDay->modify('+1 day');
    }

    return $result;
}


