<?php
session_start();
//alterar isso futuramente quando tiver banco de dados
$filePath = '../global/data/data.json';
$data = [];

if (file_exists($filePath)) {
    $json = file_get_contents($filePath);
    $data = json_decode($json, true) ?? [];
}
/* esse codigo pega os dados do aluno do suap que vamos utilizar na aplicação e salva num arquivo json, 
futuramente vamos implementar no banco de dados, como não queremos alterar os dados de ninguem do suap 
nesta aplicação a intenção e o usuario logar pelo suap pela primeira vez, salvar os dados de usuario no 
nosso banco e poder utilizar os dados na nossa aplicação, poderiamos utilizar o metodo de registro para facilitar
porem como essa aplicação está sendo feita para alunos e funcionarios do ifg o login pelo suap faz com que quem não tem conta ativa no ifg
não consiga logar nessa aplicação, então com este metodo fazemos com que o usuario se registre na nossa aplicação pelo login do suap e salvamos os dados por la.
logo após isso o aluno ou funcionario e redirecionado para o perfil, onde faremos um put no nosso banco de dados para salvar dados que não vem do suap, como senha e telefone para contato
esse metodo agora verifica se a matricula existe no json, se existir ele não altera o json, se não existir ele altera, futuramente podemos atualizar isso para verificar se o usuario ja está registrado
na nossa base de dados, se estiver ele não subscreve os dados, se não estiver ele adiciona, para toda vez que o aluno for fazer login pelo suap ele não sobrescrever os dados dele.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($data['matricula'] === $_POST['matricula']) {
        $updatedData = [
            'data_nascimento' => $_POST['data_nascimento'] ?? $data['data_nascimento'],
            'email' => $_POST['email'] ?? $data['email'],
            'matricula' => $_POST['matricula'] ?? $data['matricula'],
            'nome_usual' => $_POST['nome_usual'] ?? $data['nome_usual'],
            'tipo_vinculo' => $_POST['tipo_vinculo'] ?? $data['tipo_vinculo'],
            'url_foto_75x100' => $_POST['url_foto_75x100'] ?? $data['url_foto_75x100'],
            'url_foto_150x200' => $_POST['url_foto_150x200'] ?? $data['url_foto_150x200'],
            'curso' => $_POST['curso'] ?? $data['curso'],
            'nome' => $_POST['nome'] ?? $data['nome'],
            'senha' => $_POST['senha'] ?? $data['senha'],
            'telefone' => $_POST['telefone'] ?? $data['telefone'],
        ];
        if (isset($_POST['tipo_vinculo'])) {
            $_SESSION['tipo_vinculo'] = $_POST['tipo_vinculo'];
        }
    } else {
        $updatedData = [
            'data_nascimento' => $_POST['data_nascimento'] ?? $data['data_nascimento'],
            'email' => $_POST['email'] ?? $data['email'],
            'matricula' => $_POST['matricula'] ?? $data['matricula'],
            'nome_usual' => $_POST['nome_usual'] ?? $data['nome_usual'],
            'tipo_vinculo' => $_POST['tipo_vinculo'] ?? $data['tipo_vinculo'],
            'url_foto_75x100' => $_POST['url_foto_75x100'] ?? $data['url_foto_75x100'],
            'url_foto_150x200' => $_POST['url_foto_150x200'] ?? $data['url_foto_150x200'],
            'curso' => $_POST['curso'] ?? $data['curso'],
            'nome' => $_POST['nome'] ?? $data['nome'],
            'senha' => $_POST['senha'] ?? null,
            'telefone' => $_POST['telefone'] ?? null,
        ];
        if (isset($_POST['tipo_vinculo'])) {
            $_SESSION['tipo_vinculo'] = $_POST['tipo_vinculo'];
        }
    }

    try {
        file_put_contents($filePath, json_encode($updatedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = "Dados atualizados com sucesso!";
    } catch (Exception $e) {
        $message = "Erro ao salvar os dados: " . $e->getMessage();
    }
    $data = $updatedData;
    header('Location: /pages/perfil');
}
