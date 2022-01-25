<?php

namespace Coff\MapController\InterpolationStrategy;

use Coff\MapController\Exception\MapControllerException;
use Coff\MapController\MapController;

class BilinearInterpolationStrategy extends InterpolationStrategy
{
    protected $dimensionKeys;
    protected $dimensionCount;

    public function calculate ($coords, MapController $mapController)
    {
        $map = $mapController->getMap();
        $this->inspect($coords, $map);

        $coordX = $coords[0];
        $coordY = $coords[1];

        echo "coordX: " . $coordX . " coordY: " . $coordY . PHP_EOL;

        if ($this->dimensionCount != 2) {
            throw new MapControllerException(__CLASS__ . ' only supports two-dimensional maps. Provided map has ' . $this->dimensionCount . ' dimensions');
        }

        [$x1, $x2] = $this->findClosestKeys(0, $coordX);
        [$y1, $y2] = $this->findClosestKeys(1, $coordY);

        echo "Closest keys X: $x1, $x2 and Y: $y1, $y2" . PHP_EOL;

        $lowXYBase = $map[$x1][$y1];
        $highYBase = $map[$x1][$y2];
        $highXBase = $map[$x2][$y1];

        echo "Values: $lowXYBase, $highYBase, $highXBase " . PHP_EOL;

        $relX = ($coordX - $x1) / ($x2 - $x1);
        $relY = ($coordY - $y1) / ($y2 - $y1);

        echo "Relative to X1, Y1 $relX, $relY". PHP_EOL;

        $lowYDiff = $map[$x2][$y1] - $map[$x1][$y1];
        $highYDiff = $map[$x2][$y2] - $map[$x1][$y2];

        $lowXDiff = $map[$x1][$y2] - $map[$x1][$y1];
        $highXDiff = $map[$x2][$y2] - $map[$x2][$y1];

        // here calculating heights for points on each line to interpolate

        $lowYH = $lowXYBase + $relX * $lowYDiff;
        $highYH = $highYBase + $relX * $highYDiff;

        echo "Results for low and high YH: " . $lowYH . ", " . $highYH . PHP_EOL;

        $lowXH = $lowXYBase + $relY * $lowXDiff;
        $highXH = $highXBase + $relY * $highXDiff;

        echo "Results for low and high XH: " . $lowXH . ", " . $highXH . PHP_EOL;

        // at this moment we have result height for both axes but still we have to interpolate them

        $result1 = $lowXH + (($highXH - $lowXH) * $relX);
        $result2 = $lowYH +  (($highYH - $lowYH) * $relY);

        echo "Results: " . $result1 . ", " . $result2 . PHP_EOL;

        // now just approximate by average value

        return ($result1 + $result2) / 2;
    }



}