<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Shape;

use AP\Geometry\Int1D\Helpers\CanNotBeSegment;
use AP\Geometry\Int1D\Helpers\Shape;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Tests\AbstractTestCase;
use function AP\Geometry\Int1D\Tests\Helpers\make;

final class SegmentTest extends AbstractTestCase
{
    public function testNormilizeSortPoints(): void
    {
        $point1 = new Point(value: 1);
        $point2 = new Point(value: 2);

        $this->assertEquals(1, $point1->value);
        $this->assertEquals(2, $point2->value);

        $segments = [
            new Segment($point1, $point2),
            new Segment($point2, $point1),
        ];

        foreach ($segments as $segment) {
            $res = $segment->normalize();

            // res include link to old segments with changed links to points
            $this->assertEquals(1, $res->point1->value);
            $this->assertEquals(2, $res->point2->value);

            // links on original segments was changed too
            $this->assertEquals(1, $segment->point1->value);
            $this->assertEquals(2, $segment->point2->value);

            // check what original points was no changed, was changes only links
            $this->assertEquals(1, $point1->value);
            $this->assertEquals(2, $point2->value);
        }
    }

    public function testNormilizeToPoint(): void
    {
        $point1 = new Point(value: 1);

        $segment = new Segment($point1, $point1);
        $res     = $segment->normalize();

        // res include link to old segments with changed links to points
        $this->assertTrue($res instanceof Point);
    }

    public function testMake(): void
    {
        $this->assertEquals(Shape::all(), make(null, null));
        $this->assertEquals(Shape::vp(1), make(1, null));
        $this->assertEquals(Shape::vn(1), make(null, 1));
        $this->assertEquals(Shape::p(1), make(1, 1)->normalize());
        $this->assertEquals(Shape::s(1, 10), make(1, 10)->normalize());
        $this->assertEquals(Shape::s(1, 10), make(10, 1)->normalize());
    }

    public function testSegmentStrict(): void
    {
        $this->assertException(CanNotBeSegment::class, function () {
            Shape::segment_strict(shape: Shape::vp(1));
        });

        $this->assertException(CanNotBeSegment::class, function () {
            Shape::segment_strict(shape: Shape::vn(1));
        });

        $this->assertException(CanNotBeSegment::class, function () {
            Shape::segment_strict(shape: Shape::all());
        });

        $this->assertEquals(Shape::s(1, 10), Shape::segment_strict(shape: Shape::s(1, 10)));
        $this->assertEquals(Shape::s(1, 10), Shape::segment_strict(shape: Shape::s(10, 1)));
        $this->assertEquals(Shape::s(10, 10), Shape::segment_strict(shape: Shape::p(10)));

        // normilize and deep copy
        $original_shape = Shape::s(10, 1);
        $new_shape      = Shape::segment_strict($original_shape);

        $this->assertEquals(Shape::s(10, 1), $original_shape);
        $this->assertEquals(Shape::s(1, 10), $new_shape);
    }
}
