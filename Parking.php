<?php
class Parking
{
    /**
     * @var array $floorPlaces Array of free seats by floor
     */

    private $floorPlaces;

    /**
     * @var array $floorForTrack Array of floor numbers for trucks
     */
    private $floorForTrack;

    /**
     *
     * Initializing the property of free parking spaces by floor
     *
     * @param    array  $initPlaces  The amount of free space on the floor. The number of floors is not limited
     *  @param    array  $initFloorForTrack  An array of initializing floor numbers for trucks
     *
     */

    function __construct($initPlaces, $initFloorForTrack)
    {
        $initArray = [];
        $initArrayForTrack = [];
        try {
            if (count($initPlaces) <= 0)
                throw new Exception("Введите кол-во мест по этажам");
            foreach ($initPlaces as $key => $number) {
                if (!is_numeric($number) || $number < 0)
                    throw new Exception("Неверное введено кол-во свободных мест на этаже " . ($key));
                $initArray[] = $number;
            }
            $this->floorPlaces = $initArray;
            if (count($initFloorForTrack) <= 0)
                throw new Exception("Введите номера этажей для грузовых");
            foreach ($initFloorForTrack as $key => $number) {
                if (!is_numeric($number) || $number > count($this->floorPlaces) || $number < 0)
                    throw new Exception("Неверное введен этаж для грузовиков " . ($key));
                $initArrayForTrack[] = $number;
            }
            $this->floorForTrack = $initArrayForTrack;
        } catch (Exception $e) {
            echo 'Ошибка: ',  $e->getMessage(), "\n";
        }
    }

    /**
     *
     * Selection of parking spaces
     *
     * @param    array  $vehicles  Array of vehicles 
     *
     */
    public function calculatePlaces(...$vehicles)
    {
        $this->printPlaces("Начальнное количество мест по этажам");
        //Looping through the list of cars
        foreach ($vehicles as $vehicle) {
            echo "\n " . $vehicle->catCode . "(";
            //Checking the parking space for the selected car
            if ($this->selectPlaces($vehicle))
                echo "y";
            else
                echo "n";
            echo ")\n";
        }
        $this->printPlaces("Количество мест по этажам после постановки машин");
    }

    /**
     *
     * Selection of parking spaces
     *
     * @param    Car  $vehicle
     * @return    bool
     *
     */
    private function selectPlaces($vehicle)
    {
        //Available floors for a vehicle
        $availableFloors = $this->floorPlaces;
        $floor = false;
        //If a truck is used, then inaccessible floors are excluded
        if ($vehicle->catCode == "t") {
            $availableFloors = array_intersect_key($availableFloors, array_flip($this->floorForTrack));
        }
        //
        foreach ($availableFloors as $key => $itemFloor) {
            //If there is space on the floor, then keep his key
            if ($itemFloor > 0) {
                $floor = $key;
                break;
            }
        };
        if ($floor !== false) {
            //Reduce the number of seats on the floor
            $this->floorPlaces[$floor] -= 1;
            return true;
        } else return false;
    }
    /**
     *
     * Displays a parking report
     *
     * @param    string  $message Message for user
     *
     */
    public function printPlaces($message)
    {
        echo "$message: \n";
        foreach ($this->floorPlaces as $key => $item) {
            echo ($key + 1) . " ; $item мест\n";
        }
    }
}
