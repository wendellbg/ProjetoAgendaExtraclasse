<?php




function getNextDaysOfWeek($daysArray, $startDate, $endDate)
{
    $filePath = '../../global/data/calendario/json/feriados.json';
    $jsonData = file_get_contents($filePath);
    $feriados = json_decode($jsonData, true);

    $dayMap = [
        "segunda" => 1,
        "terça" => 2,
        "quarta" => 3,
        "quinta" => 4,
        "sexta" => 5,
        "sabado" => 6,
    ];

    $weekDaysPT = [
        "Monday" => "Segunda",
        "Tuesday" => "Terça",
        "Wednesday" => "Quarta",
        "Thursday" => "Quinta",
        "Friday" => "Sexta",
        "Saturday" => "Sabado"
    ];

    $result = [];
    $daysOfWeekNumbers = array_map(fn($day) => $dayMap[strtolower($day)], $daysArray);

    $nextDay = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    while ($nextDay <= $endDate) {
        $isFeriado = false;

        foreach ($feriados as $feriado) {
            if ($feriado['start'] === $nextDay->format('Y-m-d')) {
                $isFeriado = true;
                break;
            }
        }

        // Se não for feriado e for um dos dias desejados, adiciona ao resultado
        $dayNumber = (int) $nextDay->format('N');
        if (!$isFeriado && in_array($dayNumber, $daysOfWeekNumbers)) {
            $dayName = $weekDaysPT[$nextDay->format('l')]; // Obtém o nome do dia em português
            $formattedDate = $nextDay->format('d/m/Y');

            $result[] = [
                "dia" => $dayName,
                "data" => $formattedDate
            ];
        }

        $nextDay->modify('+1 day');
    }

    return json_encode($result, JSON_PRETTY_PRINT); // Retorna o JSON formatado
}
