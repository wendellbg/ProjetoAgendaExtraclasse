<?php
require '../../../vendor/autoload.php';

use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = '../../../global/data/calendario/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . basename($_FILES['pdf']['name']);
        $fileType = mime_content_type($_FILES['pdf']['tmp_name']);

        // Verifica se o arquivo realmente é um PDF
        if ($fileType !== 'application/pdf') {
            echo "Erro: O arquivo enviado não é um PDF válido.<br>";
            exit;
        }


        // Sobrescreve o arquivo caso já exista verifica se tem pdf no post pra sobrescrever, evita sobrescrever pra vazio o pdf,
        //  o motivo na real de ter esse cara e pra não encher de arquivo no servidor e esse primeiro if e pra evitar que ele sobrescreva o pdf existente para nada.
        if ($_FILES['pdf']) {
            if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
                echo "Arquivo enviado com sucesso!<br>";
                processPDF($uploadFile);  // Processar o PDF
            } else {
                echo "Erro ao mover o arquivo para uploads.<br>";
            }
        }
    } else {
        echo "Erro no envio do arquivo.<br>";
        var_dump($_POST);
    }
}


function processPDF($filePath)
{
    $parser = new Parser();
    $pdf = $parser->parseFile($filePath);
    $text = $pdf->getText();
    $text = mb_convert_encoding($text, 'UTF-8', 'auto');
    $inicioSemestre = isset($_POST['inicio_semestre']) ? $_POST['inicio_semestre'] : null;
    $fimSemestre = isset($_POST['fim_semestre']) ? $_POST['fim_semestre'] : null;

    if (!$inicioSemestre || !$fimSemestre) {
        echo "Erro: Data de início ou fim do semestre não fornecida.";
        return;
    }
    extractCalendarDataToJson($text, $inicioSemestre, $fimSemestre);
}

function extractCalendarDataToJson($text, $inicioSemestre, $fimSemestre)
{
    preg_match_all('/([A-Za-zçÇ]+\/\d{4})(.*?)(?=([A-Za-zçÇ]+\/\d{4})|$)/s', $text, $matches, PREG_SET_ORDER);

    $keywords = [
        'Recesso Acadêmico' => ['type' => 'recesso', 'color' => 'purple'],
        'Férias docentes' => ['type' => 'ferias', 'color' => 'yellow'],
        'Férias discentes' => ['type' => 'ferias', 'color' => 'yellow'],
        'Feriado Nacional' => ['type' => 'feriado Nacional', 'color' => 'orange'],
        'feriado municipal' => ['type' => 'feriado municipal', 'color' => 'orange'],
        'ponto facultativo' => ['type' => 'feriado facultativo', 'color' => 'orange'],
    ];

    $allDaysActivities = [];

    foreach ($matches as $section) {
        $monthYear = trim($section[1]);
        $content = trim($section[2]);

        $lines = explode("\n", $content);
        $mergedLines = [];
        $ignoreNextLine = false;

        // Unindo linhas quebradas e ignorando legenda e padrões indesejados
        for ($i = 0; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) {
                continue;
            }

            // Verifica se a próxima linha é uma continuação (não começa com número)
            while (isset($lines[$i + 1]) && !preg_match('/^\d{1,2}/', trim($lines[$i + 1]))) {
                $line .= ' ' . trim($lines[$i + 1]); // Concatena a linha seguinte
                $i++; // Avança para a próxima linha
            }

            $mergedLines[] = $line;
        }

        // Processando as linhas já corrigidas
        foreach ($mergedLines as $line) {
            $line = trim($line);

            if (empty($line) || preg_match('/^Q|^\d{1,2}(?:\s+\d{1,2})*$/', $line)) {
                continue;
            }

            if (preg_match('/^(\d{1,2})(?:\s*[-–—]\s*(\d{1,2}))?\s*(.*)$/', $line, $matches)) {
                $dayStart = (int) $matches[1];
                $dayEnd = !empty($matches[2]) ? (int) $matches[2] : $dayStart;
                $activity = trim($matches[3]);


                foreach ($keywords as $keyword => $info) {
                    if (stripos($activity, $keyword) !== false) {
                        $formattedMonthYear = parseDateFromMonthYear($monthYear);

                        for ($day = $dayStart; $day <= $dayEnd; $day++) {
                            $date = DateTime::createFromFormat('d/m/Y', "$day/$formattedMonthYear");
                            if ($date) {
                                $formattedDate = $date->format('Y-m-d');
                                if (!isset($allDaysActivities[$formattedDate])) {
                                    $allDaysActivities[$formattedDate] = [
                                        'start' => $formattedDate,
                                        'title' => $info['type'],
                                        'overlap' => false,
                                        'display' => 'background',
                                        'color' => $info['color']
                                    ];
                                }
                            } else {
                                die("Erro ao converter a data: $day/$formattedMonthYear");
                            }
                        }
                        break;
                    }
                }
            }
        }
    }

    // Converte o array associativo para um array indexado
    $allDaysActivities = array_values($allDaysActivities);

    // Adicionando informações do semestre
    $jsonInicioFim = [];
    if ($inicioSemestre && $fimSemestre) {
        $jsonInicioFim[] = [
            'inicio_semestre' => $inicioSemestre,
            'fim_semestre' => $fimSemestre,
        ];
    }

    // Criando diretório se não existir
    $dirPath = '../../../global/data/calendario/json';
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0777, true);
    }

    // Caminho dos arquivos JSON
    $filePath = $dirPath . '/feriados.json';
    $fileInicioFim = $dirPath . '/Inicio_fim.json';

    // Salvando os arquivos JSON
    file_put_contents($filePath, json_encode($allDaysActivities, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    file_put_contents($fileInicioFim, json_encode($jsonInicioFim, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return $filePath; // Retorna o caminho do JSON gerado
}














function convertMonthNameToNumber($monthName)
{
    $months = [
        'JANEIRO' => '01',
        'FEVEREIRO' => '02',
        'MARÇO' => '03',
        'ABRIL' => '04',
        'MAIO' => '05',
        'JUNHO' => '06',
        'JULHO' => '07',
        'AGOSTO' => '08',
        'SETEMBRO' => '09',
        'OUTUBRO' => '10',
        'NOVEMBRO' => '11',
        'DEZEMBRO' => '12'
    ];
    return isset($months[strtoupper($monthName)]) ? $months[strtoupper($monthName)] : false;
}

function parseDateFromMonthYear($monthYear)
{
    list($monthName, $year) = explode('/', $monthYear);
    $monthNumber = convertMonthNameToNumber($monthName);

    if ($monthNumber === false) {
        return "Mês inválido";
    }

    // Agora a data será corretamente formatada como 'm/Y'
    return date('m/Y', strtotime("$monthNumber/01/$year"));
}

















// $filePath = '../../../global/data/calendario/json/feriados.json';