<?php
require_once "../php/classes/db.php";
$db = new Db();
$con = $db->getConnection();
$temps = [];
$humidity = [];
$date = date('Y-m-d');
$sql = "SELECT * FROM `temperatures` WHERE `time` LIKE ? AND `date` = ? ORDER BY `temperature` DESC LIMIT 1";
for($i=1; $i < 25; $i++){
    if($i < 10){
        $arg = "0" . $i . ":%";

    } else {
        $arg = $i . ":%";
    }
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ss', $arg, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if(!isset($data['temperature'])){
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
    <title>Vnadaag</title>
    <script>
        const temps = <?= json_encode($temps) ?>;
        const humidity = <?= json_encode($humidity) ?>;
        const labels = [
            "01:00", '02:00', '03:00', '04:00',
            '05:00', '06:00', '07:00', '08:00',
            '09:00', '10:00', '11:00', '12"00', '13:00', '14:00',
            '15:00', '16:00', '17:00', '18:00',
            '19:00', '20:00', '21:00', '22:00',
            '23:00', '00:00'
        ];
    </script>
</head>
<body>
<?php
require_once "../layout/partials/navbar.php";
?>
<h1 class="text-center">Temperatuur en luchtvochtigheid vandaag</h1>
<?php
require_once "../layout/partials/chart.php"
?>
</body>
</html>
