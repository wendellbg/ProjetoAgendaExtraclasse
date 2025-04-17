<?php

class Login
{


    public function post($dataNascimento, $email, $matricula, $nomeUsual, $tipoVinculo, $image, $curso, $nome)
    {
        require('../../global/bd/config.php');

        $stmt = $conn->prepare("INSERT INTO tabela_login 
        (data_nascimento, email, matricula, nome_usual, tipo_vinculo, image , curso, nome) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssss", $dataNascimento, $email, $matricula, $nomeUsual, $tipoVinculo, $image, $curso, $nome);
        $success = $stmt->execute();


        $stmt->close();
        $conn->close();

        return $success;
    }


    public function put($telefone, $matricula, $nome, $email)
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

    public function changeImage($image, $matricula)
    {
        require('../../../global/bd/config.php');

        $stmt = $conn->prepare("UPDATE tabela_login SET image = ? WHERE matricula = ?");
        $stmt->bind_param("ss", $image, $matricula);
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
            'image' => $row->image,
            'curso' => $row->curso
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
