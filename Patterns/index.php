<?php

include  './Factory/5.php';
include "./Singleton/Logs/Log.php";

$gaz_station = new GazStation(6);

$car1 = new Car(40, 50);
$car2 = new Car(20, 45);
$car3 = new Car(20, 80);

$truck = new Truck(5, 250);
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

echo 'Ended, view log (Singleton -> Logs -> base.log)';