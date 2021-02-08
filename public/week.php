<?php
    require_once "../php/classes/db.php";
    $db = new Db();
    $con = $db->getConnection();
    $dates = [];
    $temps = [];
    $humidity = [];
    $dateArray = explode('-', date('d-D-m-Y'));
    [$today, $dayOfWeek, $month, $year] = $dateArray;
    $today = (int) $today;
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    switch ($dayOfWeek){
        case "Mon":
            $startDay = $today;
            break;
        case "Tue":
            $startDay = $today -1;
            break;
        case "Wed":
            $startDay = $today -2;
            break;
        case "Sun":
            $startDay = $today -6;
    }
    $labels = [];
    $endDay = $startDay + 6;
    for($i =0; $i <= 6; $i++) {
        array_push($labels, sprintf("%s %s %s", $startDay + $i, $month, $year));
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
        const labels = <?= json_encode($labels) ?>;
    </script>
    <title>Week</title>
</head>
<body>
<?php
require_once "../layout/partials/navbar.php";
?>
<h1 class="text-center">Temperatuur en luchtvochtigheid deze week</h1>
<?php
require_once "../layout/partials/chart.php"
?>
</body>
</html>
