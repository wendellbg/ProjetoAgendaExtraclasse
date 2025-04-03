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
                            <th scope="col">ATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($userProf as $data) {
                            // Extrai os dias e horários em arrays separados
                            $dias = array_column($data["dia"], "dia");
                            $horarios = array_column($data["dia"], "hora");

                            // Cria um mapa associativo de dia => horário
                            $horarioPorDia = array_combine($dias, $horarios);
                        ?>
                            <tr class="paragraph">
                                <th scope='row'><?php echo htmlspecialchars($userData['email']); ?> </th>
                                <td><?php echo htmlspecialchars($data['nome_professor']); ?></td>
                                <td><?php echo htmlspecialchars($data['local']); ?></td>

                                <!-- Exibe o horário correspondente a cada dia -->
                                <td><?php echo isset($horarioPorDia["Segunda"]) ? htmlspecialchars($horarioPorDia["Segunda"]) : ''; ?></td>
                                <td><?php echo isset($horarioPorDia["Terça"]) ? htmlspecialchars($horarioPorDia["Terça"]) : ''; ?></td>
                                <td><?php echo isset($horarioPorDia["Quarta"]) ? htmlspecialchars($horarioPorDia["Quarta"]) : ''; ?></td>
                                <td><?php echo isset($horarioPorDia["Quinta"]) ? htmlspecialchars($horarioPorDia["Quinta"]) : ''; ?></td>
                                <td><?php echo isset($horarioPorDia["Sexta"]) ? htmlspecialchars($horarioPorDia["Sexta"]) : ''; ?></td>

                                <td><?php echo htmlspecialchars($userData['telefone']); ?></td>
                                <td class="ata-btn"><a href="/pages/professor/?id=<?php echo htmlspecialchars($data['userID']); ?>">Ver materias</a></td>
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