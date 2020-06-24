<?php
require_once "php/classes/db.php";
$db = new Db();
$con = $db->getConnection();
$temps = [];
$humidity = [];
$year = date('Y');
$sql = "select * from `temperatures` where `date` like ? order by `temperature` desc limit 1";
for($i=1; $i < 13; $i += 1){
    if($i < 10){
        $arg = $year . "-0" . $i . "-%";
    } else {
        $arg = $year . "-0" . $i . "-%";
    }
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $arg);
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
            labels: [
                'januari',
                'febauri',
                'maart',
                'april',
                'mei',
                'juni',
                'juli',
                'augustus',
                'september',
                'oktober',
                'november',
                'december'
            ],
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
