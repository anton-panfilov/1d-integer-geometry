<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Helpers;

use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\All;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Shape\Vector;
use AP\Structure\Collection\AbstractCollection;

class Shape
{
    static public function p(int $v): Point
    {
        return new Point(value: $v);
    }

    static public function s(int $p1, int $p2): Segment
    {
        return new Segment(point1: self::p($p1), point2: self::p($p2));
    }

    static public function v(int $p, bool $pos): Vector
    {
        return new Vector(point: self::p($p), directionTowardsPositiveInfinity: $pos);
    }

    static public function vp(int $p): Vector
    {
        return self::v($p, true);
    }

    static public function vn(int $p): Vector
    {
        return self::v($p, false);
    }

    static public function all(): All
    {
        return new All();
    }

    static public function col(array|AbstractShape|AbstractCollection $data = []): ShapesCollection
    {
        return new ShapesCollection($data);
    }

    static public function make(?int $min, ?int $max): AbstractShape
    {
        if (is_int($min) && is_int($max)) {
            return self::s($min, $max)->normalize();
        }
        if (is_int($min)) {
            return self::vp($min);
        }
        if (is_int($max)) {
            return self::vn($max);
        }
        return self::all();
    }
}