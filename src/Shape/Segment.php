<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

class Segment extends AbstractShape
{
    public function __construct(
        public Point $point1,
        public Point $point2,
    )
    {
    }

    public function min(): Point
    {
        return $this->point2->value >= $this->point1->value ?
            $this->point1 : $this->point2;
    }

    public function max(): Point
    {
        return $this->point1->value <= $this->point2->value ?
            $this->point2 : $this->point1;
    }

    public function normalize(): Segment|Point
    {
        if ($this->point1->value == $this->point2->value) {
            return $this->point1;
        }

        // sort points
        if ($this->point1->value > $this->point2->value) {
            $temp         = $this->point1;
            $this->point1 = $this->point2;
            $this->point2 = $temp;
        }

        return $this;
    }
}