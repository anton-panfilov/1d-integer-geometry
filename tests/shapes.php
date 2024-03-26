<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Helpers;

use AP\Geometry\Int1D\Helpers\Shape;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\All;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;

function p(int $v): Point
{
    return Shape::p(v: $v);
}

function s(int $p1, int $p2): Segment
{
    return Shape::s(p1: $p1, p2: $p2);
}

function v(int $p, bool $pos): Vector
{
    return Shape::v(p: $p, pos: $pos);
}

function vp(int $p): Vector
{
    return Shape::vp(p: $p);
}

function vn(int $p): Vector
{
    return Shape::vn(p: $p);
}

function all(): All
{
    return Shape::all();
}

function make(?int $min, ?int $max): AbstractShape
{
    return Shape::make(min: $min, max: $max);
}