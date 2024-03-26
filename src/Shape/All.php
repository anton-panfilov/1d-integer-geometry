<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

use AP\Geometry\Int1D\Exception\Infinity;

class All extends AbstractShape
{
    /**
     * @throws Infinity
     */
    public function min(): Point
    {
        throw new Infinity();
    }

    /**
     * @throws Infinity
     */
    public function max(): Point
    {
        throw new Infinity();
    }
}