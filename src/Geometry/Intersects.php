<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Geometry;

use AP\Geometry\Int1D\Exception\NoIntersectsException;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\All;
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
            if ($shape2 instanceof All) return true;
        }
        if ($shape1 instanceof Segment) {
            if ($shape2 instanceof Point) return self::intersectsPointAndSegment(point: $shape2, segment: $shape1);
            if ($shape2 instanceof Segment) return self::intersectsSegments(segment1: $shape1, segment2: $shape2);
            if ($shape2 instanceof Vector) return self::intersectsSegmentAndVector(segment: $shape1, vector: $shape2);
            if ($shape2 instanceof All) return true;
        }
        if ($shape1 instanceof Vector) {
            if ($shape2 instanceof Point) return self::intersectsPointAndVector(point: $shape2, vector: $shape1);
            if ($shape2 instanceof Segment) return self::intersectsSegmentAndVector(segment: $shape2, vector: $shape1);
            if ($shape2 instanceof Vector) return self::intersectsVectors(vector1: $shape1, vector2: $shape2);
            if ($shape2 instanceof All) return true;
        }
        if ($shape1 instanceof All) {
            return true;
        }

        $shape1_str = get_debug_type($shape1);
        $shape2_str = get_debug_type($shape2);
        throw new RuntimeException(
            "internal error: 'intersectsShapes' no implemented for shapes: {$shape1_str}, {$shape2_str}"
        );
    }

    /**
     * @throws NoIntersectsException
     */
    public static function getIntersectsShape(AbstractShape $shape1, AbstractShape $shape2): AbstractShape
    {
        if ($shape1 instanceof Point) {
            if ($shape2 instanceof Point) return self::getIntersectsPoints(point1: $shape1, point2: $shape2);
            if ($shape2 instanceof Segment) return self::getIntersectsPointAndSegment(point: $shape1, segment: $shape2);
            if ($shape2 instanceof Vector) return self::getIntersectsPointAndVector(point: $shape1, vector: $shape2);
            if ($shape2 instanceof All) return $shape1->normalize();
        }
        if ($shape1 instanceof Segment) {
            if ($shape2 instanceof Point) return self::getIntersectsPointAndSegment(point: $shape2, segment: $shape1);
            if ($shape2 instanceof Segment) return self::getIntersectsSegments(segment1: $shape1, segment2: $shape2);
            if ($shape2 instanceof Vector) return self::getIntersectsSegmentAndVector(segment: $shape1, vector: $shape2);
            if ($shape2 instanceof All) return $shape1->normalize();
        }
        if ($shape1 instanceof Vector) {
            if ($shape2 instanceof Point) return self::getIntersectsPointAndVector(point: $shape2, vector: $shape1);
            if ($shape2 instanceof Segment) return self::getIntersectsSegmentAndVector(segment: $shape2, vector: $shape1);
            if ($shape2 instanceof Vector) return self::getIntersectsVectors(vector1: $shape1, vector2: $shape2);
            if ($shape2 instanceof All) return $shape1->normalize();
        }
        if ($shape1 instanceof All) {
            return $shape2->normalize();
        }

        $shape1_str = get_debug_type($shape1);
        $shape2_str = get_debug_type($shape2);
        throw new RuntimeException(
            "internal error: 'getIntersectsShape' no implemented for shapes: {$shape1_str}, {$shape2_str}"
        );
    }

    //////////////////////////////////////////

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

    //////////////////////////////////////////

    protected static function getIntersectsPoints(Point $point1, Point $point2): AbstractShape
    {
        if (self::intersectsPoints($point1, $point2)) {
            return new Point(value: $point1->value);
        }
        throw new NoIntersectsException();
    }

    protected static function getIntersectsPointAndSegment(Point $point, Segment $segment): AbstractShape
    {
        if (self::intersectsPointAndSegment($point, $segment)) {
            return new Point(value: $point->value);
        }
        throw new NoIntersectsException();
    }

    protected static function getIntersectsPointAndVector(Point $point, Vector $vector): AbstractShape
    {
        if (self::intersectsPointAndVector($point, $vector)) {
            return new Point(value: $point->value);
        }
        throw new NoIntersectsException();
    }

    protected static function getIntersectsSegments(Segment $segment1, Segment $segment2): AbstractShape
    {
        if (self::intersectsSegments($segment1, $segment2)) {
            return (new Segment(
                point1: new Point(max($segment1->min()->value, $segment2->min()->value)),
                point2: new Point(min($segment1->max()->value, $segment2->max()->value)),
            ))->normalize();
        }
        throw new NoIntersectsException();
    }

    protected static function getIntersectsSegmentAndVector(Segment $segment, Vector $vector): AbstractShape
    {
        if (self::intersectsSegmentAndVector($segment, $vector)) {
            if ($vector->directionTowardsPositiveInfinity) {
                return (new Segment(
                    point1: new Point(max($vector->point->value, $segment->min()->value)),
                    point2: $segment->max()
                ))->normalize();
            } else {
                return (new Segment(
                    point1: $segment->min(),
                    point2: new Point(min($vector->point->value, $segment->max()->value)),
                ))->normalize();
            }
        }
        throw new NoIntersectsException();
    }

    protected static function getIntersectsVectors(Vector $vector1, Vector $vector2): AbstractShape
    {
        if (self::intersectsVectors($vector1, $vector2)) {
            if ($vector1->directionTowardsPositiveInfinity == $vector2->directionTowardsPositiveInfinity) {
                return new Vector(
                    point: new Point(
                        value: $vector1->directionTowardsPositiveInfinity ?
                            max($vector1->point->value, $vector2->point->value) :
                            min($vector1->point->value, $vector2->point->value)
                    ),
                    directionTowardsPositiveInfinity: $vector1->directionTowardsPositiveInfinity
                );
            } else {
                return (new Segment(
                    point1: $vector1->point,
                    point2: $vector2->point,
                ))->normalize();
            }
        }
        throw new NoIntersectsException();
    }

}