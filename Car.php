<?php
class Car
{
    /**
     * @var string $catCode Vehicle category code. Values: t(Truck), c(car);
     */
    public $catCode;

    /**
     *
     * Initializing the property of free parking spaces by floor
     *
     * @param    array  $initPlaces  The amount of free space on the floor. The number of floors is not limited
     *
     */

    function __construct($categoryCode)
    {
        $this->catCode = $categoryCode;
    }
}
