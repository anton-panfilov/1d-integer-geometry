<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Geometry;

use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;
use AP\Geometry\Int1D\Exception\NoIntersectsException;

class Exclude
{
    /**
     * @return ShapesCollection [Segment | Point]{0,2}
     * @throws NoIntersectsException
     */
    public static function excludePointFromSegment(
        Point   $excludePoint,
        Segment $originalSegment
    ): ShapesCollection
    {
        if (!Intersects::intersectsPointAndSegment($excludePoint, $originalSegment)) {
            throw new NoIntersectsException();
        }

        if ($originalSegment->point1->value == $originalSegment->point2->value) {
            // segment is point, exclude intersected point from point is nothing
            // it require before next blocks, because +1 -1 with one point segment going to bad result
            return new ShapesCollection([]);
        }

        if ($excludePoint->value == $originalSegment->min()->value) {
            return new ShapesCollection([
                (new Segment(
                    point1: new Point($excludePoint->value + 1),
                    point2: clone $originalSegment->max(),
                ))->normalize()
            ]);
        }

        if ($excludePoint->value == $originalSegment->max()->value) {
            return new ShapesCollection([
                (new Segment(
                    point1: clone $originalSegment->min(),
                    point2: new Point($excludePoint->value - 1),
                ))->normalize()
            ]);
        }

        return new ShapesCollection([
            (new Segment(
                point1: clone $originalSegment->min(),
                point2: new Point($excludePoint->value - 1),
            ))->normalize(),
            (new Segment(
                point1: new Point($excludePoint->value + 1),
                point2: clone $originalSegment->max(),
            ))->normalize()
        ]);
    }

    /**
     * @return ShapesCollection [Vector] or [Point, Vector] or [Segment, Vector]
     * @throws NoIntersectsException
     */
    public static function excludePointFromVector(
        Point  $excludePoint,
        Vector $originalVector
    ): ShapesCollection
    {
        if (!Intersects::intersectsPointAndVector($excludePoint, $originalVector)) {
            throw new NoIntersectsException();
        }

        $correction = $originalVector->directionTowardsPositiveInfinity ? 1 : -1;

        if ($excludePoint->value == $originalVector->point->value) {
            return new ShapesCollection([
                (new Vector(
                    point: new Point($excludePoint->value + $correction),
                    directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity
                ))
            ]);
        }

        return new ShapesCollection([
            (new Segment(
                point1: clone $originalVector->point,
                point2: (new $excludePoint->value - $correction),
            ))->normalize(),
            (new Vector(
                point: (new $excludePoint->value + $correction),
                directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity
            ))
        ]);
    }

    /**
     * @return ShapesCollection [Segment | Point]{0,2}
     * @throws NoIntersectsException
     */
    public static function excludeSegmentFromSegment(
        Segment $excludeSegment,
        Segment $originalSegment
    ): ShapesCollection
    {
        if (!Intersects::intersectsSegments($excludeSegment, $originalSegment)) {
            throw new NoIntersectsException();
        }

        $excludeSegmentMin = $originalSegment->min()->value;
        $excludeSegmentMax = $originalSegment->max()->value;

        $originalSegmentMin = $excludeSegment->min()->value;
        $originalSegmentMax = $excludeSegment->max()->value;

        if ($excludeSegmentMin <= $originalSegmentMin && $excludeSegmentMax >= $originalSegmentMax) {
            // full intersects
            return new ShapesCollection([]);
        }

        $result = new ShapesCollection();

        if ($excludeSegmentMin > $originalSegmentMin) {
            $result[] = (new Segment(
                point1: new Point(value: $originalSegmentMin),
                point2: new Point(value: $excludeSegmentMin - 1),
            ))->normalize();
        }

        if ($excludeSegmentMax < $originalSegmentMax) {
            $result[] = (new Segment(
                point1: new Point(value: $excludeSegmentMax + 1),
                point2: new Point(value: $originalSegmentMax),
            ))->normalize();
        }

        return $result;
    }

    /**
     * @throws NoIntersectsException
     */
    public static function excludeSegmentFromVector(
        Segment $excludeSegment,
        Vector  $originalVector
    ): ShapesCollection
    {
        if (!Intersects::intersectsSegmentAndVector($excludeSegment, $originalVector)) {
            throw new NoIntersectsException();
        }

        $segmentMin = $excludeSegment->min()->value;
        $segmentMax = $excludeSegment->max()->value;

        $result = new ShapesCollection();

        if ($originalVector->directionTowardsPositiveInfinity) {
            if ($segmentMin > $originalVector->point->value) {
                $result[] = (new Segment(
                    point1: clone $originalVector->point,
                    point2: new Point(value: $segmentMin - 1)
                ))->normalize();
            }
            $result[] = new Vector(
                point: new Point(value: $segmentMax + 1),
                directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity,
            );
        } else {
            $result[] = new Vector(
                point: new Point(value: $segmentMin - 1),
                directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity,
            );
            if ($segmentMax < $originalVector->point->value) {
                $result[] = (new Segment(
                    point1: new Point(value: $segmentMax + 1),
                    point2: clone $originalVector->point
                ))->normalize();
            }
        }

        return $result;
    }

    /**
     * @return ShapesCollection [Segment | Point]{0, 1}
     * @throws NoIntersectsException
     */
    public static function excludeVectorFromSegment(
        Vector  $excludeVector,
        Segment $originalSegment,
    ): ShapesCollection
    {
        if (!Intersects::intersectsSegmentAndVector($originalSegment, $excludeVector)) {
            throw new NoIntersectsException();
        }

        $segmentMin = $originalSegment->min()->value;
        $segmentMax = $originalSegment->min()->value;

        if(
            ($excludeVector->directionTowardsPositiveInfinity && $excludeVector->point->value <= $segmentMin)
            || (!$excludeVector->directionTowardsPositiveInfinity && $excludeVector->point->value >= $segmentMax)
        ){
            // full intersects
            return new ShapesCollection([]);
        }

        $result = new ShapesCollection([]);

        if($excludeVector->directionTowardsPositiveInfinity){
            $result[] = (new Segment(
                point1: new Point(value: $segmentMin),
                point2: new Point(value: $excludeVector->point->value - 1),
            ))->normalize();
        } else {
            $result[] = (new Segment(
                point1: new Point(value: $excludeVector->point->value + 1),
                point2: new Point(value: $segmentMax),
            ))->normalize();
        }

        return $result;
    }

    /**
     * @return ShapesCollection [Vector | Segment | Point]{0, 1}
     * @throws NoIntersectsException
     */
    public static function excludeVectorFromVector(
        Vector $excludeVector,
        Vector $originalVector
    ): ShapesCollection
    {
        if (!Intersects::intersectsVectors($originalVector, $excludeVector)) {
            throw new NoIntersectsException();
        }

        $result = new ShapesCollection();

        if ($excludeVector->directionTowardsPositiveInfinity == $originalVector->directionTowardsPositiveInfinity) {
            if (
                $excludeVector->directionTowardsPositiveInfinity
                && $excludeVector->point->value > $originalVector->point->value
            ) {
                $result[] = (new Segment(
                    point1: new Point(value: $originalVector->point->value),
                    point2: new Point(value: $excludeVector->point->value - 1),
                ))->normalize();
            } elseif (
                !$excludeVector->directionTowardsPositiveInfinity
                && $excludeVector->point->value < $originalVector->point->value
            ) {
                $result[] = (new Segment(
                    point1: new Point(value: $excludeVector->point->value + 1),
                    point2: new Point(value: $originalVector->point->value),
                ))->normalize();
            }
        } else {
            $result[] = (new Vector(
                point: new Point(value: $originalVector->directionTowardsPositiveInfinity ?
                    $excludeVector->point->value + 1:
                    $excludeVector->point->value - 1
                ),
                directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity,
            ));
        }
        return $result;
    }
}