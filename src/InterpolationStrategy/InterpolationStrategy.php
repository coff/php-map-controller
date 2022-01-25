<?php

namespace Coff\MapController\InterpolationStrategy;

use Coff\MapController\Exception\MapControllerException;
use Coff\MapController\MapController;

abstract class InterpolationStrategy
{
    protected $dimensionCount;
    protected $dimensionKeys;

    abstract public function calculate($values, MapController $map);

    public function inspect ($values, $map)
    {
        $this->dimensionCount = 0;
        $this->findDimensionKeys($map, $this->dimensionKeys, $this->dimensionCount);
    }

    protected function findDimensionKeys($arr, &$dimensionsKeys, &$dimensionCount, $index = 0)
    {
        $dimensionsKeys[$index] = $keys = array_keys($arr);
        $dimensionCount++;

        if (is_array($arr[$keys[0]])) {
            $this->findDimensionKeys($arr[$keys[0]], $dimensionsKeys, $dimensionCount, $index+1);
        }
    }

    /**
     * @param $dimension
     * @param $value
     * @return array
     * @throws MapControllerException
     */
    protected function findClosestKeys($dimension, $value) {
        foreach ($this->dimensionKeys[$dimension] as $dimensionsKey) {

            if ($dimensionsKey > $value) {
                return [$last, $dimensionsKey];
            }

            $last = $dimensionsKey;
        }

        throw new MapControllerException(sprintf("Can't estabilish closest key points for dimension %s and value %s",
            $dimension, $value));
    }
}