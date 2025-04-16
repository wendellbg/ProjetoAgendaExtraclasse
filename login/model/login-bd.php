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
        $success = $stmt->execute();


        $stmt->close();
        $conn->close();

        return $success;
    }


    public function put($senha, $telefone, $matricula, $nome, $email)
    {
        require('../../../global/bd/config.php');

        $stmt = $conn->prepare("UPDATE tabela_login SET telefone = ?, nome_usual = ?, email = ? WHERE matricula = ?");
        $stmt->bind_param("ssss", $telefone, $nome, $email, $matricula);
        $success = $stmt->execute();


        $stmt->close();
        $conn->close();

        if (!$success) {
            die("Erro ao atualizar dados: " . $stmt->error);
        }
        return $success;
    }
    public function changePassword($senha, $matricula)
    {
        require('../../../global/bd/config.php');
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE tabela_login SET senha = ? WHERE matricula = ?");
        $stmt->bind_param("ss", $senhaHash, $matricula);
        $success = $stmt->execute();


        $stmt->close();
        $conn->close();

        if (!$success) {
            die("Erro ao atualizar dados: " . $stmt->error);
        }
        return $success;
    }


    public function getMatricula($matricula)
    {
        require('../../global/bd/config.php');
        $stmt = $conn->prepare("SELECT matricula FROM tabela_login WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_object();
            return $row->matricula;
        }
        $stmt->close();
        $conn->close();

        return "";
    }

    public function getUser($matricula)
    {
        require_once('../../global/bd/config.php');

        $stmt = $conn->prepare("SELECT * FROM tabela_login  WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_object();

        $stmt->close();
        $conn->close();

        $data = [
            'id' => $row->id,
            'nome_usual' => $row->nome_usual,
            'email' => $row->email,
            'senha' => $row->senha,
            'matricula' => $row->matricula,
            'curso' => $row->curso,
            'telefone' => $row->telefone,
            'url_foto_150x200' => $row->url_foto_75x100,
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
        $stmt->close();
        $conn->close();
        return false;
    }
}
