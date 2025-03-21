<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>professor</title>
    <?php include '../../global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">

            <div class="container-prof">


                <form method="post" class="form-prof">
                    <!-- materia -->
                    <label for="" class="materia paragraph">
                        <span class="paragraph">
                            Materia
                        </span>
                        <input type="text" name="materia" class="paragraph">
                    </label>
                    <!-- data -->
                    <div class="data">
                        <span class="paragraph">Data</span>
                        <button type="button" id="open-modal" class="btn-prof"><i class="fa-solid fa-circle-plus"></i></button>
                    </div>
                    <!-- curso -->
                    <label for="" class="curso">
                        <span class="paragraph">Curso</span>
                        <select name="curso" id="" class="paragraph">
                            <option value="BSI">BSI</option>
                            <option value="Licenciatura em Química">Licenciatura em Química</option>
                            <option value="Técnico Integrado em Edificações">Técnico Integrado em Edificações</option>
                            <option value="Técnico Integrado em Informática pela Internet">Técnico Integrado em Informática pela Internet</option>
                            <option value="Técnico Integrado em Manutenção e Suporte em Informática">Técnico Integrado em Manutenção e Suporte em Informática</option>
                            <option value="Técnico Integrado em Química">Técnico Integrado em Química</option>
                        </select>
                    </label>
                    <!-- foto -->
                    <div class="foto">
                        <label for="formFile" id="span_imagem" class="form-label img-label">
                            <div id="img"></div>
                        </label>
                        <input type="file" accept="image/*" name="foto" id="formFile">
                    </div>
                    <div class="botao-container">
                        <input type="submit" value="Registrar" class="subtitle button-form">
                    </div>
                </form>
                <!-- dialog -->
                <div id="my-dialog" style="display: none;">
                    <div class="title-data">
                        <h3 class="subtitle">Data</h3>
                        <button id="close-dialog" class="close"><i class="fa-solid fa-circle-xmark"></i></button>
                    </div>

                    <form method="post" class="form-dia">
                        <label for="diaSemana" class="curso">
                            <span class="paragraph">Dia do atendimento</span>
                            <select class="paragraph" name="diaSemana" id="diaSemana">
                                <option value="Segunda">Segunda</option>
                                <option value="Terça">Terça</option>
                                <option value="Quarta">Quarta</option>
                                <option value="Quinta">Quinta</option>
                                <option value="Sexta">Sexta</option>
                            </select>
                        </label>
                        <button type="submit" class="btn-prof"><i class="fa-solid fa-circle-plus"></i></button>
                    </form>

                    <div class="dia-container">
                        <ul id="listaDias"></ul>
                    </div>
                    <div class="botao-container">
                        <!-- <button class="subtitle button-form" id="registrar">Registrar</button> -->
                    </div>

                </div>

        </Main>
    </div>
</body>

<script>
    //abrir fechar modal
    $('#open-modal').on('click', () => {
        $('#my-dialog').show(); // Exibe o modal
    });

    $('#close-dialog').on('click', () => {
        $('#my-dialog').hide(); // Esconde o modal
    });
    // selecionar dia modal
    let diasSelecionados = [];

    $('.form-dia').on('submit', function(e) {
        e.preventDefault();
        let diaSelecionado = $('#diaSemana').val();
        if (!diasSelecionados.includes(diaSelecionado)) {
            diasSelecionados.push(diaSelecionado);
            atualizarLista();
        }
    });


    function removerDia(dia) {
        diasSelecionados = diasSelecionados.filter(d => d !== dia);
        atualizarLista();
    }

    function atualizarLista() {
        $('#listaDias').empty(); // Limpa a lista
        if (diasSelecionados.length > 0) {
            diasSelecionados.forEach(dia => {
                $('#listaDias').append(`
                        <li class="paragraph dia-semana-li">
                            ${dia} 
                            <button  class="remover-dia" data-dia="${dia}"><i class="fa-solid fa-xmark"></i></button>
                        </li>
                    `);
            });


            $('.remover-dia').on('click', function() {
                let diaParaRemover = $(this).data('dia');
                removerDia(diaParaRemover);
            });
        }
    }
    //imagem

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




    // enviar os dados

    $('.form-prof').on('submit', (e) => {
        e.preventDefault();

        const materia = $("[name='materia']").val();
        const curso = $("[name='curso']").val();
        const base64 = base64String;
        const diasSelecionados = ['Segunda', 'Quarta'];

        let formData = new FormData();
        formData.append("materia", materia);
        formData.append("curso", curso);
        formData.append("image", base64); // Se for uma imagem base64, deve ser tratada corretamente.
        formData.append("dia", JSON.stringify(diasSelecionados));
        formData.append('imageName', file.name)

        console.log(file.name);

        $.ajax({
            url: "./php/prof.post.php",
            method: "POST",
            data: formData,
            processData: false, // Não processa os dados
            contentType: false, // Não define o tipo de conteúdo para multipart/form-data
            success: function(response) {
                console.log("Resposta do servidor:", response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erro ao enviar os dados:", textStatus, errorThrown);
            },
        });
    });
</script>

</html>