<!-- @Author: Kamaev Anton -->
<!-- @Date: 2024-10-28 -->
<!-- @Version: 1.0 -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <title>Gaz Station</title>

  <style>
    body {
      height: 100vh;

      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;

      font-family: 'Montserrat', sans-serif;
    }

    .bold {
      font-weight: 600;
    }
  </style>
</head>
<body>
<?php

include './Factory/GazStation.php';
include "./Singleton/Logs/Log.php";
include "./Strategy/Strategy.php";

echo '<h1>GAZ STATION</h1>' . PHP_EOL;

$gaz_station = new GazStation(6);

$car1 = new Car(40, 50);
$car2 = new Car(20, 45);
$car3 = new Car(20, 80);

$truck = new Truck(0.2, 250);
$truck2 = new Truck(60, 200);

$moto1 = new Motorcycle(5, 15);

$gaz_station->addVehicle($car1);
$gaz_station->addVehicle($car2);
$gaz_station->addVehicle($car3);

$gaz_station->addVehicle($truck);
$gaz_station->addVehicle($truck2);

$gaz_station->addVehicle($moto1);

$gaz_station->refuelVehicleById(3, 300, 'diesel', 1);
$gaz_station->refuelVehicleById(0, 14, '95', 2);
$gaz_station->refuelVehicleById(2, 22, '92', 3);
$gaz_station->refuelVehicleById(1, 15, '100', 4);
$gaz_station->refuelVehicleById(4, 120, 'diesel', 5);

$gaz_station->refuelVehicleById(5, 10, '92', 5);

$log = Log::getInstance()->getFileLogs();

Log::getInstance()->info( "FINAL INCOME: " . round($gaz_station->getFinalIncome(), 2));

echo "<div style='display: flex; align-items: center; gap: 5px; margin-top: 20px;'>Logs saved in + Final income: <span style='color: gray; font-weight: bold'>$log</span></div>";
?>
</body>
</html>
