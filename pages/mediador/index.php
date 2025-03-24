<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>

    <title>Mediador</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <div class="container">


        <?php include '../../global/header/Header.php' ?>


        <Main class="Main-container">

            <div class="mediador-container">

                <!-- formulario -->
                <form action="./php/mediador.php" method="POST" class="form-mediador" enctype="multipart/form-data">
                    <label for="">
                        <span class="paragraph">Inicio semestre</span>
                        <input class="paragraph" type="date" name="inicio_semestre">
                    </label>

                    <label for="">
                        <span class="paragraph">Fim semestre</span>
                        <input class="paragraph" type="date" name="fim_semestre">
                    </label>
                    <label for="pdf">
                        <span class="paragraph">
                            Selecione o pdf do calendario academico
                        </span>
                        <input class="paragraph" type="file" name="pdf" id="pdf" accept="application/pdf">
                    </label>
                    <div class="button-container">
                        <button type="submit" class="button-form subtitle">Enviar</button>
                    </div>
                </form>


                <!-- tabela professor -->

                <?php
                $filePath = '../../global/data/professor.data.json';
                $filePathUser = '../../global/data/data.json';

                if (file_exists($filePath) && file_exists($filePathUser)) {
                    $jsonData = file_get_contents($filePath);
                    $jsonDataUser = file_get_contents($filePathUser);

                    $userData = json_decode($jsonDataUser, true);
                    $userProf = json_decode($jsonData, true);
                }
                ?>
                <table>
                    <caption class="subtitle">
                        Horário dos professores
                    </caption>
                    <thead>
                        <tr class="subtitle">
                            <th scope="col">Endereço de email</th>
                            <th scope="col">Nome do docente</th>
                            <th scope="col">Local</th>
                            <th scope='col'>Segunda</th>
                            <th scope='col'>Terça</th>
                            <th scope='col'>Quarta</th>
                            <th scope='col'>Quinta</th>
                            <th scope='col'>Sexta</th>
                            <th scope="col">Contato Docente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($userProf as $data) {

                            $dias = $data['dia'];
                            $horario = $data['horario'];
                        ?>
                            <tr class="paragraph">
                                <th scope='row'><?php echo htmlspecialchars($userData['email']); ?> </th>
                                <td "><?php echo htmlspecialchars($data['nome_professor']); ?></td>
                                <td ><?php echo htmlspecialchars($data['local']); ?></td>
                                <td><?php echo (in_array("Segunda", $dias)) ? htmlspecialchars($horario) : ''; ?></td>
                                <td><?php echo (in_array("Terça", $dias)) ? htmlspecialchars($horario) : ''; ?></td>
                                <td><?php echo (in_array("Quarta", $dias)) ? htmlspecialchars($horario) : ''; ?></td>
                                <td><?php echo (in_array("Quinta", $dias)) ? htmlspecialchars($horario) : ''; ?></td>
                                <td><?php echo (in_array("Sexta", $dias)) ? htmlspecialchars($horario) : ''; ?></td>

                                <td><?php echo htmlspecialchars($userData['telefone']); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>



            </div>


        </Main>
    </div>
</body>

</html>