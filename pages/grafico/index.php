<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include '../../global/php/head.php' ?>
    <title>grafico</title>
    <link rel="stylesheet" href="./css/style.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['materia', 'qtdAlunos'],
                ['Work', 11],
                ['Eat', 2],
                ['Commute', 2],
                ['Watch TV', 2],
                ['Sleep', 7],
                ['Exercise', 8]
            ]);

            var options = {
                title: 'Quantidade de alunos por atendimento'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div class="container">

        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            <div class="grafico-container">
                <div id="piechart" class="grafico"></div>
            </div>
        </Main>
    </div>

</body>

</html>