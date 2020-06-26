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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/chart.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <script>
        const temps = <?= json_encode($temps) ?>;
        const humidity = <?= json_encode($humidity) ?>;
        const labels = [
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
        ];
    </script>
    <title>jaar</title>
</head>
<body>
<?php
require_once "layout/partials/navbar.php";
?>
<h1 class="text-center">Temperatuur en luchtvochtigheid dit jaar</h1>
<?php
require_once "layout/partials/chart.php"
?>
</body>
</html>
