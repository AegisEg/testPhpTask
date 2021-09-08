<?php
require "Parking.php";
require "Car.php";
$parking = new Parking([2, 2, 5], [0]);
$parking->calculatePlaces(new Car("t"), new Car("c"), new Car("c"), new Car("t"));
