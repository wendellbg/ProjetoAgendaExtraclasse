<?php
require '../../../vendor/autoload.php';

use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = '../../../global/data/calendario/uploads/';
    $oldUploadDir = '../../../global/data/calendario/oldUploads/';

    // Criando diretórios, se necessário
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (!is_dir($oldUploadDir)) {
        mkdir($oldUploadDir, 0777, true);
    }

    // Movendo arquivos antigos para oldUploads/
    $files = array_diff(scandir($uploadDir), array('..', '.'));

    foreach ($files as $file) {
        $oldFilePath = $uploadDir . $file;
        $newFilePath = $oldUploadDir . time() . "_" . $file;

        if (rename($oldFilePath, $newFilePath)) {
            echo "Arquivo '$file' movido para 'oldUploads' como '$newFilePath'.<br>";
        } else {
            echo "Erro ao mover o arquivo '$file' para 'oldUploads'.<br>";
        }
    }

    // Verifica se o arquivo PDF foi enviado
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . basename($_FILES['pdf']['name']);
        $fileType = mime_content_type($_FILES['pdf']['tmp_name']);

        // Verifica se o arquivo realmente é um PDF
        if ($fileType !== 'application/pdf') {
            echo "Erro: O arquivo enviado não é um PDF válido.<br>";
            exit;
        }

        // Move o arquivo para uploads
        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
            echo "Arquivo enviado com sucesso!<br>";
            processPDF($uploadFile);  // Processar o PDF
        } else {
            echo "Erro ao mover o arquivo para uploads.<br>";
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

    // Recebe as datas de início e fim do semestre a partir do formulário
    $inicioSemestre = isset($_POST['inicio_semestre']) ? $_POST['inicio_semestre'] : null;
    $fimSemestre = isset($_POST['fim_semestre']) ? $_POST['fim_semestre'] : null;

    if (!$inicioSemestre || !$fimSemestre) {
        echo "Erro: Data de início ou fim do semestre não fornecida.";
        return;
    }

    // Passa as datas para a função que irá processar o conteúdo do PDF
    extractCalendarDataToJson($text, $inicioSemestre, $fimSemestre);
}

function extractCalendarDataToJson($text, $inicioSemestre, $fimSemestre)
{
    preg_match_all('/([A-Za-zçÇ]+\/\d{4})(.*?)(?=([A-Za-zçÇ]+\/\d{4})|$)/s', $text, $matches, PREG_SET_ORDER);
    $keywords = [
        'recesso',
        'férias',
        'feriado'
    ];

    $firstMonthYear = null;
    $lastMonthYear = null;

    $allDaysActivities = [];

    foreach ($matches as $section) {
        $monthYear = trim($section[1]);
        $content = trim($section[2]);

        $daysActivities = [];
        $firstDay = null;
        $lastDay = null;

        if ($firstMonthYear === null) {
            $firstMonthYear = $monthYear;
        }
        $lastMonthYear = $monthYear;

        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line) || preg_match('/^Q|^\d{1,2}(?:\s+\d{1,2})*$/', $line)) {
                continue;
            }

            if (preg_match('/^(\d{1,2})(?:\s*[\–\-]?\s*(.*))$/', $line, $matches)) {
                $day = $matches[1];
                $activity = isset($matches[2]) ? $matches[2] : 'Sem atividade registrada';

                if ($firstDay === null) {
                    $firstDay = $day;
                }
                $lastDay = $day;

                foreach ($keywords as $keyword) {
                    if (stripos($activity, $keyword) !== false) {
                        $daysActivities[] = "$day - $activity";
                        break;
                    }
                }
            }
        }

        if (!empty($daysActivities)) {
            $allDaysActivities[$monthYear] = $daysActivities;
        }
    }

    // Aqui, estamos apenas extraindo as atividades sem adicionar o início e fim de semestre
    $jsonData = [];

    foreach ($allDaysActivities as $monthYear => $activities) {
        $jsonData[] = [
            'month_year' => $monthYear,
            'activities' => $activities
        ];
    }

    $jsonInico_fim = [];
    if ($inicioSemestre && $fimSemestre) {
        $jsonInico_fim[] = [
            'inicio_semestre' => $inicioSemestre,
            'fim_semestre' => $fimSemestre,
        ];
    }

    if (!is_dir('../../../global/data/calendario/json')) {
        mkdir('../../../global/data/calendario/json');
    }
    $fileInicio_fim = '../../../global/data/calendario/json/Inicio_fim.json';
    $filePath = '../../../global/data/calendario/json/feriados.json';

    file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    file_put_contents($fileInicio_fim, json_encode($jsonInico_fim, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return $filePath;
}







// $filePath = '../../../global/data/calendario/json/feriados.json';