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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/chart.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <script src="assets/js/jquery.min.js" defer></script>
    <script src="assets/js/bootstrap.min.js" defer></script>
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
    <title>Week</title>
</head>
<body>
<?php
require_once "layout/partials/navbar.php";
?>
<h1 class="text-center">Temperatuur en luchtvochtigheid deze week</h1>
<?php
require_once "layout/partials/chart.php"
?>
</body>
</html>
