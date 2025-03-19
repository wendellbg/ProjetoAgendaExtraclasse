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
            <form action="./php/prof.post.php" method="post" class="form-prof">
                <!-- materia -->
                <label for="" class="materia paragraph">
                    <span class="paragraph">
                        Materia
                    </span>
                    <input type="text">
                </label>
                <!-- data -->
                <div class="data">
                    <span class="paragraph">Data</span>
                    <button type="button"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <!-- curso -->
                <label for="" class="curso">
                    <span class="paragraph">Curso</span>
                    <select name="" id="">
                        <option value="">a</option>
                        <option value="">b</option>
                        <option value="">c</option>
                    </select>
                </label>
                <!-- foto -->
                <div class="foto">
                    <label for="formFile" id="span_imagem" class="form-label img-label">
                        <div id="img"></div>
                    </label>
                    <input type="file" accept="image/*" class="" id="formFile">
                </div>
                <div class="botao-container">
                    <input type="submit" value="Registrar" class="subtitle button-form">
                </div>
            </form>

        </Main>
    </div>


    <script>
        const base64String = ""
        $('#formFile').on('change', function(event) {
            const file = event.target.files[0]; // Obtém o arquivo selecionado
            if (file) {
                const reader = new FileReader(); // Cria o FileReader para ler o arquivo

                reader.addEventListener('load', (e) => {
                    const base64String = e.target.result; // A string Base64 da imagem

                    $('#span_imagem').css({
                        'border': 'none',
                        'background': 'none'
                    });

                    // Atualiza o conteúdo do elemento com id 'img' com a imagem ou a mensagem 'Escolha uma imagem'
                    $('#img').html(base64String ?
                        `<img src="${base64String}" class="img">` :
                        '<span class="paragraph">Escolha uma imagem</span>');
                });

                reader.readAsDataURL(file); // Converte o arquivo para Base64
            } else {
                console.log('Nenhum arquivo selecionado.');
            }
            
        });

        // Atualiza o conteúdo do elemento com id 'img' com a imagem ou a mensagem 'Escolha uma imagem'
        $('#img').html(base64String ?
                        `<img src="${base64String}" class="img">` :
                        '<span class="paragraph">Escolha uma imagem</span>');
    </script>
</body>


</html>