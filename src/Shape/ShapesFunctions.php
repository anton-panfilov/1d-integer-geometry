<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

function p(int $v): Point
{
    return new Point(value: $v);
}

function s(int $p1, int $p2): Segment
{
    return new Segment(point1: p($p1), point2: p($p2));
}

function v(int $p, bool $pos): Vector
{
    return new Vector(point: p($p), directionTowardsPositiveInfinity: $pos);
}