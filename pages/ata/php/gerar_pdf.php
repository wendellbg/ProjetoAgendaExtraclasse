<?php
require '../../../vendor/autoload.php';

use Dompdf\Dompdf;

use Dompdf\Options;

// Configuração do Dompdf
$options = new Options();
$options->set('defaultFont', 'roboto');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Obtém o HTML enviado via POST
$html = $_POST['html'] ?? '<h1>Erro ao gerar PDF</h1>';

// Caminho absoluto para a imagem
$imgPath = "../image/logo-full-ifg.png";
$imgBase64 = "data:image/jpeg;base64," . base64_encode(file_get_contents($imgPath));

// Substituir o caminho da imagem no HTML
$html = str_replace('./image/logo-full-ifg.png', $imgBase64, $html);

// Carregar CSS externo
$css = file_get_contents('../css/style.css');
$html = "<style>" . $css . "</style>" . $html;
// Define o HTML no Dompdf
$dompdf->loadHtml($html);


$dompdf->setPaper('A4', 'landscape');

// Renderiza o PDF
$dompdf->render();

$dompdf->stream("ata-atendimento.pdf", ["Attachment" => false]);
