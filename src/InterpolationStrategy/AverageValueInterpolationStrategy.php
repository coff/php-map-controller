<?php

namespace Coff\MapController\InterpolationStrategy;

use Coff\MapController\MapController;

class AverageValueInterpolationStrategy extends InterpolationStrategy
{
    protected $dimensionKeys;

    public function calculate ($values, MapController $mapController)
    {
        $map = $mapController->getMap();
        $this->inspect($values, $map);

    }

}

foreach ($this->inputValues as $dimension => $value) {
    $points = $this->findClosestKeys($dimension, $value);
    $distance[$dimension] = ($value - $points[0]) / ($points[1] - $points[0]);
    echo "for " . $value . " found " . $points[0] . ' and ' . $points[1] . ", value is in " . $distance[$dimension] ." distance ". PHP_EOL;

    $closestKeys[$dimension]['low'] = $points[0];
    $closestKeys[$dimension]['high'] = $points[1];
    //print_r($distance[$dimension]); echo PHP_EOL;
}