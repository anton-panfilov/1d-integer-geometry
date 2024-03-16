<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Geometry;

use AP\Geometry\Int1D\Exception\NoIntersectsException;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Shape\Vector;
use RuntimeException;

class Exclude
{
    /**
     * @throws NoIntersectsException
     */
    public static function exclude(
        AbstractShape|ShapesCollection $exclude,
        AbstractShape|ShapesCollection $original,
    ): ShapesCollection
    {
        // temp solution
        if ($exclude instanceof AbstractShape && $original instanceof AbstractShape) {
            return self::excludeShapeFromShape(
                exclude: $exclude,
                original: $original
            );
        }

        return self::excludeCollectionFromCollection(
            excludeCollection: new ShapesCollection($exclude),
            originalCollection: new ShapesCollection($exclude),
        );
    }

    protected static function excludeCollectionFromCollection(
        ShapesCollection $excludeCollection,
        ShapesCollection $originalCollection,
    ): ShapesCollection
    {
        throw new RuntimeException("no implemented");
    }

    /**
     * @throws NoIntersectsException
     */
    protected static function excludeShapeFromShape(
        AbstractShape $exclude,
        AbstractShape $original,
    ): ShapesCollection
    {
        if ($exclude instanceof Point) {
            if ($original instanceof Point) return self::excludePointFromPoint($exclude, $original);
            if ($original instanceof Segment) return self::excludePointFromSegment($exclude, $original);
            if ($original instanceof Vector) return self::excludePointFromVector($exclude, $original);
        }
        if ($exclude instanceof Segment) {
            if ($original instanceof Point) return self::excludeSegmentFromPoint($exclude, $original);
            if ($original instanceof Segment) return self::excludeSegmentFromSegment($exclude, $original);
            if ($original instanceof Vector) return self::excludeSegmentFromVector($exclude, $original);
        }
        if ($exclude instanceof Vector) {
            if ($original instanceof Point) return self::excludeVectorFromPoint($exclude, $original);
            if ($original instanceof Segment) return self::excludeVectorFromSegment($exclude, $original);
            if ($original instanceof Vector) return self::excludeVectorFromVector($exclude, $original);
        }
        throw new RuntimeException(
            "undefined exclude methods for excluded: " . get_debug_type($exclude) .
            ", original: " . get_debug_type($original)
        );
    }

    /**
     * @throws NoIntersectsException
     */
    protected static function excludeShapeFromPoint(
        AbstractShape $excludeShape,
        Point         $originalPoint
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($excludeShape, $originalPoint)) {
            throw new NoIntersectsException();
        }
        return new ShapesCollection();
    }

    /**
     * @throws NoIntersectsException
     */
    protected static function excludePointFromPoint(
        Point $excludePoint,
        Point $originalPoint
    ): ShapesCollection
    {
        return self::excludeShapeFromPoint(
            excludeShape: $excludePoint,
            originalPoint: $originalPoint
        );
    }

    /**
     * @throws NoIntersectsException
     */
    protected static function excludeSegmentFromPoint(
        Segment $excludeSegment,
        Point   $originalPoint
    ): ShapesCollection
    {
        return self::excludeShapeFromPoint(
            excludeShape: $excludeSegment,
            originalPoint: $originalPoint
        );
    }

    /**
     * @throws NoIntersectsException
     */
    protected static function excludeVectorFromPoint(
        Vector $excludeVector,
        Point  $originalPoint
    ): ShapesCollection
    {
        return self::excludeShapeFromPoint(
            excludeShape: $excludeVector,
            originalPoint: $originalPoint
        );
    }

    /**
     * @return ShapesCollection [Segment | Point]{0,2}
     * @throws NoIntersectsException
     */
    protected static function excludePointFromSegment(
        Point   $excludePoint,
        Segment $originalSegment
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($excludePoint, $originalSegment)) {
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
    protected static function excludePointFromVector(
        Point  $excludePoint,
        Vector $originalVector
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($excludePoint, $originalVector)) {
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
                point2: new Point($excludePoint->value - $correction),
            ))->normalize(),
            (new Vector(
                point: new Point($excludePoint->value + $correction),
                directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity
            ))
        ]);
    }

    /**
     * @return ShapesCollection [Segment | Point]{0,2}
     * @throws NoIntersectsException
     */
    protected static function excludeSegmentFromSegment(
        Segment $excludeSegment,
        Segment $originalSegment
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($excludeSegment, $originalSegment)) {
            throw new NoIntersectsException();
        }

        $originalSegmentMin = $originalSegment->min()->value;
        $originalSegmentMax = $originalSegment->max()->value;

        $excludeSegmentMin = $excludeSegment->min()->value;
        $excludeSegmentMax = $excludeSegment->max()->value;

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
    protected static function excludeSegmentFromVector(
        Segment $excludeSegment,
        Vector  $originalVector
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($excludeSegment, $originalVector)) {
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
    protected static function excludeVectorFromSegment(
        Vector  $excludeVector,
        Segment $originalSegment,
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($originalSegment, $excludeVector)) {
            throw new NoIntersectsException();
        }

        $segmentMin = $originalSegment->min()->value;
        $segmentMax = $originalSegment->max()->value;

        if (
            ($excludeVector->directionTowardsPositiveInfinity && $excludeVector->point->value <= $segmentMin)
            || (!$excludeVector->directionTowardsPositiveInfinity && $excludeVector->point->value >= $segmentMax)
        ) {
            // full intersects
            return new ShapesCollection([]);
        }

        $result = new ShapesCollection([]);

        if ($excludeVector->directionTowardsPositiveInfinity) {
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
    protected static function excludeVectorFromVector(
        Vector $excludeVector,
        Vector $originalVector
    ): ShapesCollection
    {
        if (!Intersects::intersectsShapes($originalVector, $excludeVector)) {
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
                    $excludeVector->point->value + 1 :
                    $excludeVector->point->value - 1
                ),
                directionTowardsPositiveInfinity: $originalVector->directionTowardsPositiveInfinity,
            ));
        }
        return $result;
    }
}