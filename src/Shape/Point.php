<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

class Point extends AbstractShape
{
    public function __construct(
        public int $value
    )
    {
    }

    public function min(): Point
    {
        return $this;
    }

    public function max(): Point
    {
        return $this;
    }
}