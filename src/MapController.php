<?php

namespace Coff\MapController;

use Coff\MapController\Exception\MapControllerException;
use Coff\MapController\InterpolationStrategy\InterpolationStrategy;

class MapController
{
    protected $map = [];
    protected $inputValues;

    /**
     * @var InterpolationStrategy
     */
    protected $interpolationStrategy;

    /**
     * Sets interpolation strategy
     *
     * @param InterpolationStrategy $interpolation
     * @return $this
     */
    public function setInterpolationStrategy(InterpolationStrategy $interpolation)
    {
        $this->interpolationStrategy = $interpolation;

        return $this;
    }

    public function setMap(array $map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setInputValues(array $values)
    {
        $this->inputValues = $values;

        return $this;
    }

    /**
     * @return array
     */
    public function getInputValues()
    {
        return $this->inputValues;
    }

    public function calculate()
    {
        if (!$this->interpolationStrategy instanceof InterpolationStrategy) {
            throw new MapControllerException('Interpolation strategy not set');
        }
        return $this->interpolationStrategy->calculate($this->inputValues, $this);
    }

/*

    public function calc() {



        foreach ($this->inputValues as $dimension => $value) {
            $points = $this->findClosestKeys($dimension, $value);
            $distance[$dimension] = ($value - $points[0]) / ($points[1] - $points[0]);
            echo "for " . $value . " found " . $points[0] . ' and ' . $points[1] . ", value is in " . $distance[$dimension] ." distance ". PHP_EOL;

            $closestKeys[$dimension]['low'] = $points[0];
            $closestKeys[$dimension]['high'] = $points[1];
            //print_r($distance[$dimension]); echo PHP_EOL;
        }

        foreach ($this->inputValues as $dimension => $obsolete) {
            $this->findPointSeries( 'low', $dimension , $closestKeys, $distance);
            $this->findPointSeries( 'high', $dimension, $closestKeys, $distance);
        }

        $retValues = [];
        $this->digResult($retValues, $this->map, 'low', $closestPoints, $distance);
        $this->digResult($retValues, $this->map, 'high', $closestPoints, $distance);

        print_r($retValues);
    }

    protected function findPointSeries($pos, $dimension, &$closestKeys, $distance) {

    }

    protected function digResult()
    {

    }


    protected function aadigResult(&$retValues, $map, $type, $closestKeys, $distances, $dimension = 0)
    {
        $closestKey = $closestKeys[$type][$dimension];
        echo 'called for ' . $dimension . "/" .$type. PHP_EOL;
        if (is_array($map[$closestKey])) {
            echo "digging deeper..." . PHP_EOL;
            $this->digResult($retValues, $map[$closestKey], $type, $closestKeys , $distances,$dimension + 1);
            $this->digResult($retValues, $map[$closestKey], 'high', $closestKeys , $distances, $dimension + 1);
        } else {
            echo "reached bottom... " . $distances[$dimension] . PHP_EOL;
            $retValues[] =
                $map[$closestKeys['low'][$dimension]] + $distances[$dimension] * ($map[$closestKeys['high'][$dimension]] - $map[$closestKeys['low'][$dimension]])
                . "/d:". $distances[$dimension] . "/" .
                $map[$closestKeys['high'][$dimension]]. "-" .
                $map[$closestKeys['low'][$dimension]];

        }
    }*/
}