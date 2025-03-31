<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include '../../global/php/head.php' ?>
    <title>ATA</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            <div class="ata-container">
                <div class="ata-area" id="conteudo-pdf">
                    <div class="scrool">
                        <div class="area-pdf">
                            <div class="header">
                                <img src="./image/logo-full-ifg.png" alt="ifg logo completo">
                            </div>

                            <div>
                                <table>
                                    <tr>
                                        <td colspan="2">ATENDIMENTO EXTRACLASSE</td>
                                    </tr>
                                    <tr>
                                        <th>Nome do Docente:</th>
                                        <td>asdasdasd</td>
                                    </tr>
                                    <tr>
                                        <th>Local:</th>
                                        <td>Sala dos Professores IFG Luziânia</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="merged" style="text-align: left; border-bottom:none;">Nas datas e horários abaixo reuniram-se docente e discentes referidos para atendimento extraclasse (reforço escolar, atendimento de dependência, orientação de trabalhos e pesquisas, entre outros).</td>
                                    </tr>
                                </table>

                                <table>
                                    <thead>
                                        <tr>
                                            <th colspan="4">DADOS DOS ESTUDANTES</th>
                                            <th colspan="5">DADOS DO ATENDIMENTO</th>

                                        </tr>
                                        <tr>
                                            <th>n.º</th>
                                            <th>Matrícula</th>
                                            <th>Estudante</th>
                                            <th>Disciplina</th>
                                            <th>Assunto</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Frequência</th>
                                            <th>imprevisto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // foreach(){
                                        ?>
                                        <tr>
                                            <td>1.</td>
                                            <td>20241080080014</td>
                                            <td>Kricys ...</td>
                                            <td>Sociologia</td>
                                            <td>Frequência nas aulas de Sábado por motivos religiosos.</td>
                                            <td>20/03/2024</td>
                                            <td>19:00:00</td>
                                            <td>f/p</td>
                                            <td>bla bla bla bla bla bla bla</td>
                                        </tr>
                                        <?php
                                        // }
                                        ?>
                                    </tbody>
                                </table>
                            </div>



                            <div class="footer">
                                <div class="footer-institute">Instituto Federal de Educação, Ciência e Tecnologia de Goiás</div>
                                <div class="footer-address">Rua São Bartolomeu, 5/N, 5/N, Vila Esperança, LUZIÂNIA / GO, CEP 72.811-580</div>
                                <div class="footer-contact">(61) 3142-1231 (ramal: 231)</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="button-container">
                    <button id="download-pdf">Baixar</button>
                </div>

        </Main>
    </div>
</body>
<script>
    document.getElementById("download-pdf").addEventListener("click", () => {
        var conteudo = document.getElementById("conteudo-pdf").outerHTML; // Captura o conteúdo da div
        var estilos = document.querySelector("head").innerHTML; // Captura todo o head, incluindo o style

        // Monta o HTML final com estilos e conteúdo
        var htmlCompleto = "<html><head>" + estilos + "</head><body>" + conteudo + "</body></html>";

        var form = document.createElement("form");
        form.method = "POST";
        form.action = "./php/gerar_pdf.php"; // Certifique-se que este script está correto

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "html";
        input.value = htmlCompleto;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    });
</script>

</html>