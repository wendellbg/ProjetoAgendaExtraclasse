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
<script src="./lib/core/locales/pt-br.global.min.js"></script>
<script>
    const feriadoUrl = '../../global/data/calendario/json/feriados.json';
    const AulaUrl = '../../global/data/aluno.data.json'

    function fetchCalendar() {
        return Promise.all([
                $.ajax({
                    url: feriadoUrl,
                    method: "GET"
                }),
                $.ajax({
                    url: AulaUrl,
                    method: "GET"
                })
            ])
            .then(([feriados, aulas]) => {

                let eventosAulas = Array.isArray(aulas) ? aulas.map(evento => ({
                    title: evento.data.title,
                    start: evento.data.start,
                    color: evento.data.color,
                    groupId: JSON.stringify(evento?.data?.idGroup),
                    display: 'list-item',
                })) : [];
                return [...feriados, ...eventosAulas];
            })
            .catch(error => {
                console.error("Erro ao buscar os dados:", error);
                return [];
            });
    }

    $(document).ready(function() {
        let user = <?php echo isset($_SESSION['tipo_vinculo'])
                        ? json_encode($_SESSION['tipo_vinculo'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
                        : '""'; ?>.toLowerCase();
        fetchCalendar().then(eventos => {

            let calendarEl = $(".calendar").get(0);
            let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: "dayGridMonth",
                    locale: "pt-br",
                    events: eventos,

                    eventClick: function(info) {
                        const eventUrl = JSON.parse(info.event.groupId);
                        console.log(eventUrl)
                        if (eventUrl) {
                            if (user === 'aluno') {
                                let url = `/pages/aluno/index.php?id=${eventUrl.id_materia}`
                                window.location.href = url;
                            } else if (user === 'professor') {
                                let url = `/pages/professor/index.php?id=${eventUrl.userID}`
                                window.location.href = url;
                            }
                        }
                    },

                }


            );

            calendar.render();
        });
    });
</script>

</html>