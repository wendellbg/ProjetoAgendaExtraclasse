<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include '../../global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">
    <title>Calendario</title>

</head>

<body>

    <div class="container">
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            <div class="calendar paragraph"></div>
        </Main>
    </div>

</body>
<script src="./lib/index.global.min.js"></script>
<script src="./lib/core/locales-all.global.min.js"></script>
<script>
    const url = '../../global/data/calendario/json/feriados.json';
    async function fetchCalendar() {
        try {
            const response = await fetch(url);
            const data = await response.json();
            if (data) {
                return data;
            }
        } catch (error) {
            console.error('Erro ao carregar o JSON:', error);
            return [];
        }
    }

    $(document).ready(function() {
        fetchCalendar().then(events => {
            let calendarEl = $('.calendar').get(0);
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                events: events
            });
            calendar.render();
        }).catch(error => {
            console.error('Erro ao configurar o calendário:', error);
        });
    });
</script>

</html>