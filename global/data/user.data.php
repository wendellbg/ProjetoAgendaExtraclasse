<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diretório e arquivo onde os dados serão salvos
    $filePath = __DIR__ . '/data.json';

    // Obtendo os dados enviados pelo AJAX
    $data = [
        'data_nascimento' => $_POST['data_nascimento'] ?? null,
        'email' => $_POST['email'] ?? null,
        'matricula' => $_POST['matricula'] ?? null,
        'nome_usual' => $_POST['nome_usual'] ?? null,
        'tipo_vinculo' => $_POST['tipo_vinculo'] ?? null,
        'url_foto_75x100' => $_POST['url_foto_75x100'] ?? null,
        'url_foto_150x200' => $_POST['url_foto_150x200'] ?? null,
        'curso' => $_POST['curso'] ?? null,
        'nome' => $_POST['nome'] ?? null,
    ];

    try {
        // Salva os dados diretamente no arquivo, sobrescrevendo o conteúdo anterior
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Resposta de sucesso
        echo json_encode(['status' => 'success', 'message' => 'Dados salvos com sucesso']);
    } catch (Exception $e) {
        // Em caso de erro
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar os dados', 'error' => $e->getMessage()]);
    }
} else {
    // Responde com erro para métodos não permitidos
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido']);
}
?>

