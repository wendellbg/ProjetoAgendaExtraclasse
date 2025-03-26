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
        if (!$isFeriado && in_array((int) $nextDay->format('N'), $daysOfWeekNumbers)) {
            $result[] = $nextDay->format('d/m/Y');
        }

        $nextDay->modify('+1 day'); // Incrementa a data APÓS verificar todos os feriados
    }

    return $result;
}
