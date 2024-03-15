<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Geometry;

use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;

class Intersects
{
    public static function intersectsPoints(Point $point1, Point $point2): bool
    {
        return $point1->value == $point2->value;
    }

    public static function intersectsPointAndSegment(Point $point, Segment $segment): bool
    {
        return $point->value >= $segment->min()->value && $point->value <= $segment->max()->value;
    }

    public static function intersectsPointAndVector(Point $point, Vector $vector): bool
    {
        return $vector->directionTowardsPositiveInfinity ?
            $point->value >= $vector->point->value :
            $point->value <= $vector->point->value;
    }

    public static function intersectsSegments(Segment $segment1, Segment $segment2): bool
    {
        return !($segment1->max() < $segment2->min() || $segment1->min() > $segment2->max());
    }

    public static function intersectsSegmentAndVector(Segment $segment, Vector $vector): bool
    {
        return $vector->directionTowardsPositiveInfinity ?
            $segment->max()->value >= $vector->point->value :
            $segment->min()->value <= $vector->point->value;
    }

    public static function intersectsVectors(Vector $vector1, Vector $vector2): bool
    {
        if ($vector1->directionTowardsPositiveInfinity == $vector2->directionTowardsPositiveInfinity) {
            return true; // if vectors directions one way, they intersect
        }
        return $vector1->directionTowardsPositiveInfinity ?
            $vector1->point->value <= $vector2->point->value :
            $vector2->point->value <= $vector1->point->value;
    }
}