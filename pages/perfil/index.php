<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">
    <title>perfil</title>
</head>

<body>

    <div class="container">
        <!-- alterar futuramente pro banco de dados -->
        <?php

        ?>
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">

            <div id="modal-change-image">
                <div id="modal-mudar-foto">
                    <div class="foto">
                        <label for="formFile" id="span_imagem" class="form-label img-label">
                            <div id="img"></div>
                        </label>
                        <input type="file" accept="image/*" name="foto" id="formFile">
                    </div>

                    <div class="button-modal-container">
                        <button class="close" id="close-button-modal-change-image"><i class="fa-solid fa-circle-xmark"></i></button>
                        <button class="alterar-button subtitle" id="alterar-image">alterar</button>
                    </div>

                </div>
            </div>

            <form class="perfil-container" method="POST" action="./php/put.php">
                <h3 class="subtitle">Os dados não serão alterados no SUAP!</h3>
                <div class="perfil-image-container">
                    <div class="image-button-container">
                        <img src="<?php echo $data['image'] ?>" alt="imagem usuario">
                        <button class="button-image" id="button-modal-change-image" type="button"><i class="fa-solid fa-pen-to-square"></i></button>
                    </div>
                </div>
                <div class="input-perfil-container">
                    <label for="name">
                        <span class="paragraph">Nome</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="name"
                            name="nome_usual"
                            value="<?= htmlspecialchars($data['nome_usual'] ?? '') ?>">
                    </label>

                    <label for="email">
                        <span class="paragraph">Email</span>
                        <input
                            class="paragraph"
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                    </label>

                    <label for="matricula">
                        <span class="paragraph">Matrícula</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="matricula"
                            name="matricula"
                            value="<?= htmlspecialchars($data['matricula'] ?? '') ?>" disabled>
                    </label>

                    <label for="curso">
                        <span class="paragraph">Curso</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="curso"
                            name="curso"
                            value="<?= htmlspecialchars($data['curso'] ?? '') ?>" disabled>
                    </label>



                    <label for="telefone">
                        <span class="paragraph">Telefone</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="telefone"
                            name="telefone"
                            value="<?= htmlspecialchars($data['telefone'] ?? '') ?>">
                    </label>
                </div>

                <div class="button-perfil-container">
                    <input type="submit" value="Alterar" class="button-perfil subtitle">
                </div>
            </form>


            <form class="password-container" method="post">
                <h3 class="subtitle">Escolha uma senha</h3>
                <label for="senha">
                    <span class="paragraph">Senha</span>
                    <input
                        class="paragraph"
                        type="password"
                        id="senha"
                        name="senha"
                        value="">
                </label>
                <label for="senha">
                    <span class="paragraph">Repetir senha</span>
                    <input
                        class="paragraph"
                        type="password"
                        id="senhaRepeat"
                        name="senhaRepeat"
                        value="">
                </label>
                <div class="button-perfil-container">
                    <input type="submit" value="atualizar senha" class="button-perfil subtitle">
                </div>
            </form>

        </Main>
    </div>

</body>
<!-- ./php/password.php -->
<script>
    $('.password-container').on('submit', (e) => {
        e.preventDefault();
        let password = $('#senha').val();
        let repeatPassword = $('#senhaRepeat').val();
        if (password || repeatPassword) {
            if (password === repeatPassword) {
                let formData = new FormData();
                formData.append("senha", password);
                // formData.forEach((res) => console.log(res))


                $.ajax({
                    url: "./php/password.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log("Resposta do servidor:", response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Erro ao enviar os dados:", textStatus, errorThrown);
                    },
                });


            } else {
                console.log('senhas diferentes')
            }
        } else {
            console.log('Digite uma senha')
        }
    })

    //abrir fechar modal
    $('#button-modal-change-image').on('click', () => {
        $('#modal-change-image').show(); // Exibe o modal
    });

    $('#close-button-modal-change-image').on('click', () => {
        $('#modal-change-image').hide(); // Esconde o modal
    });

    //image
    let base64String = "";
    let file = ''
    $('#formFile').on('change', function(event) {
        file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', (e) => {
                base64String = e.target.result;

                $('#span_imagem').css({
                    'border': 'none',
                    'background': 'none'
                });
                $('#img').html(base64String ?
                    `<img src="${base64String}" class="img">` :
                    '<span class="paragraph">Escolha uma imagem</span>');
            });

            reader.readAsDataURL(file);
        } else {
            console.log('Nenhum arquivo selecionado.');
        }

    });

    //enviar form

    $('#img').html(base64String ?
        `<img src="${base64String}" class="img">` :
        '<span class="paragraph">Escolha uma imagem</span>');




    $("#alterar-image").on('click', () => {
        if (base64String) {

            let formData = new FormData();
            formData.append("image", base64String);
            // formData.forEach((res) => console.log(res))


            $.ajax({
                url: "./php/changeImage.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Enviado com sucesso!");
                    window.location.href = "/pages/perfil";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erro ao enviar os dados:", textStatus, errorThrown);
                },
            });
        }
    })
</script>

</html>