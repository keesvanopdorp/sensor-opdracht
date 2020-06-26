<?php
require_once "php/classes/db.php";
$db = new Db();
$con = $db->getConnection();
$temps = [];
$humidity = [];
$year = date('Y');
$month = date('m');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$sql = "select * from `temperatures` where `date` = ? order by `temperature` desc limit 1";
for($i=1; $i < $daysInMonth + 2; $i += 1){
    $arg = sprintf('%s-%s-%s', $year, $month, $i);
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
    <script src="assets/js/jquery.min.js" defer></script>
    <script src="assets/js/bootstrap.min.js" defer></script>
    <script>
        const temps = <?= json_encode($temps) ?>;
        const humidity = <?= json_encode($humidity) ?>;
        const daysInMonth = <?= json_encode($daysInMonth) ?>;
        const labels = [];
        for(let i=0; i < daysInMonth + 1; i +=1){
            labels.push(i);
        }
    </script>
    <title>Maand</title>
</head>
<body>
<?php
require_once "layout/partials/navbar.php";
?>
<h1 class="text-center">Temperatuur en luchtvochtigheid deze maand</h1>
<?php
require_once "layout/partials/chart.php"
?>
</body>
</html>
