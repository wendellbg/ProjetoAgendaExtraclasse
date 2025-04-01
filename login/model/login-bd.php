<?php

class Login
{


    public function post($dataNascimento, $email, $matricula, $nomeUsual, $tipoVinculo, $foto75x100, $foto150x200, $curso, $nome)
    {
        require('../../global/bd/config.php');

        $stmt = $conn->prepare("INSERT INTO tabela_login 
        (data_nascimento, email, matricula, nome_usual, tipo_vinculo, url_foto_75x100, url_foto_150x200, curso, nome) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssss", $dataNascimento, $email, $matricula, $nomeUsual, $tipoVinculo, $foto75x100, $foto150x200, $curso, $nome);
    }


    public function put($senha, $telefone, $matricula)
    {
        require('../../../global/bd/config.php');
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE tabela_login SET senha = ?, telefone = ? WHERE matricula = ?");
        $stmt->bind_param("sss", $senhaHash, $telefone, $matricula);

        if (!$stmt->execute()) {
            die("Erro ao atualizar dados: " . $stmt->error);
        }
    }


    public function getMatricula($matricula)
    {
        require('../../global/bd/config.php');

        // Usa Prepared Statements para evitar SQL Injection
        $stmt = $conn->prepare("SELECT matricula FROM tabela_login WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_object();
            return $row->matricula;
        }

        return "";
    }

    public function getUser($matricula)
    {
        require_once('../../global/bd/config.php'); // Garante que a conexão seja incluída apenas uma vez

        $stmt = $conn->prepare("SELECT telefone, senha ,curso ,matricula ,email ,nome_usual FROM tabela_login  WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_object();

        $stmt->close();

        $data = [
            'nome_usual' => $row->nome_usual,
            'email' => $row->email,
            'senha' => $row->senha,
            'matricula' => $row->matricula,
            'curso' => $row->curso,
            'telefone' => $row->telefone
        ];
        return $data;
    }




    public function HasLogin($matricula, $senha)
    {
        require('../../global/bd/config.php');

        $stmt = $conn->prepare("SELECT * FROM tabela_login WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_object();
            if (password_verify($senha, $row->senha)) {
                $_SESSION['tipo_vinculo'] = $row->tipo_vinculo;
                $_SESSION['matricula'] = $matricula;
                return true;
            }
        }
        return false;
    }
}
