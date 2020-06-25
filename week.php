<?php
    require_once "php/classes/db.php";
    $db = new Db();
    $con = $db->getConnection();
    $dates = [];
    $temps = [];
    $humidity = [];
    $startDay = 22;
    for($i =0; $i < 8; $i++){
        $date = "2020-06-" .  ($startDay + $i);
        array_push($dates, $date);
    }
    foreach ($dates as $date){
        $sql = "select * from `temperatures` where `date` = ? order by `temperature` desc limit 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if(!$data['temperature']){
            array_push($temps, "");
            array_push($humidity, "");
        } else {
            array_push($temps, $data['temperature']);
            array_push($humidity, $data['humidity']);
        }
    }
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        const temps = <?= json_encode($temps) ?>;
        const humidity = <?= json_encode($humidity) ?>;
        const labels = [
                "22 juni 2020",
                '23 juni 2020',
                '24 juni 2020',
                '25 juni 2020',
                '26 juni 2020',
                '27 juni 2020',
                '28 juni 2020',
                '29 juni 2020'
        ];
    </script>
    <title>Document</title>
</head>
<body>
<canvas id="chart"></canvas>
<script src="assets/js/chart.min.js"></script>
<script>
    const ctx = document.querySelector('#chart').getContext('2d');
    /**
     *
     * @const {Chart} chart
     */
    const chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: labels,
            datasets: [{
                label: "temperatuur",
                borderColor: 'rgb(0,152,38)',
                data: temps,
            },
                {
                    label: "luchtvochtigheid",
                    borderColor: 'rgb(20, 1, 100)',
                    data: humidity
                }]
        },

        // Configuration options go here
        options: {
            elements: {
                line: {
                    fill: false
                }
            }
        }
    });
</script>
</body>
</html>
