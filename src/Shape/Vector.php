<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

use AP\Geometry\Int1D\Exception\Infinity;

class Vector extends AbstractShape
{
    public function __construct(
        public Point $point,
        public bool  $directionTowardsPositiveInfinity
    )
    {
    }

    /**
     * @return Point
     * @throws Infinity
     */
    public function min(): Point
    {
        if (!$this->directionTowardsPositiveInfinity) {
            // point->value is int, it is impossible to use -INF here
            throw new Infinity();
        }
        return $this->point;
    }

    /**
     * @return Point
     * @throws Infinity
     */
    public function max(): Point
    {
        if ($this->directionTowardsPositiveInfinity) {
            // point->value is int, it is impossible to use INF here
            throw new Infinity();
        }
        return $this->point;
    }
}