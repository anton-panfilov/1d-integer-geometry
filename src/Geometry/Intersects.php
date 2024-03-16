<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Geometry;

use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;
use RuntimeException;

class Intersects
{
    public static function intersectsShapes(AbstractShape $shape1, AbstractShape $shape2): bool
    {
        if ($shape1 instanceof Point) {
            if ($shape2 instanceof Point) return self::intersectsPoints(point1: $shape1, point2: $shape2);
            if ($shape2 instanceof Segment) return self::intersectsPointAndSegment(point: $shape1, segment: $shape2);
            if ($shape2 instanceof Vector) return self::intersectsPointAndVector(point: $shape1, vector: $shape2);
        }
        if ($shape1 instanceof Segment) {
            if ($shape2 instanceof Point) return self::intersectsPointAndSegment(point: $shape2, segment: $shape1);
            if ($shape2 instanceof Segment) return self::intersectsSegments(segment1: $shape1, segment2: $shape2);
            if ($shape2 instanceof Vector) return self::intersectsSegmentAndVector(segment: $shape1, vector: $shape2);
        }
        if ($shape1 instanceof Vector) {
            if ($shape2 instanceof Point) return self::intersectsPointAndVector(point: $shape2, vector: $shape1);
            if ($shape2 instanceof Segment) return self::intersectsSegmentAndVector(segment: $shape2, vector: $shape1);
            if ($shape2 instanceof Vector) return self::intersectsVectors(vector1: $shape1, vector2: $shape2);
        }
        throw new RuntimeException(
            "undefined intersects methods shape1: " . get_debug_type($shape1) .
            ", shape2: " . get_debug_type($shape2)
        );
    }

    protected static function intersectsPoints(Point $point1, Point $point2): bool
    {
        return $point1->value == $point2->value;
    }

    protected static function intersectsPointAndSegment(Point $point, Segment $segment): bool
    {
        return $point->value >= $segment->min()->value && $point->value <= $segment->max()->value;
    }

    protected static function intersectsPointAndVector(Point $point, Vector $vector): bool
    {
        return $vector->directionTowardsPositiveInfinity ?
            $point->value >= $vector->point->value :
            $point->value <= $vector->point->value;
    }

    protected static function intersectsSegments(Segment $segment1, Segment $segment2): bool
    {
        return !($segment1->max() < $segment2->min() || $segment1->min() > $segment2->max());
    }

    protected static function intersectsSegmentAndVector(Segment $segment, Vector $vector): bool
    {
        return $vector->directionTowardsPositiveInfinity ?
            $segment->max()->value >= $vector->point->value :
            $segment->min()->value <= $vector->point->value;
    }

    protected static function intersectsVectors(Vector $vector1, Vector $vector2): bool
    {
        if ($vector1->directionTowardsPositiveInfinity == $vector2->directionTowardsPositiveInfinity) {
            return true; // if vectors directions one way, they intersect
        }
        return $vector1->directionTowardsPositiveInfinity ?
            $vector1->point->value <= $vector2->point->value :
            $vector2->point->value <= $vector1->point->value;
    }
}