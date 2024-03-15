<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

abstract class AbstractShape
{
    abstract public function min(): Point;
    abstract public function max(): Point;

    /**
     * Change shape type it this shape can be described more simple.
     *  example Segment(1,1) -> Point(1)
     *
     * @return $this
     */
    public function normalize(): AbstractShape
    {
        return $this;
    }
}