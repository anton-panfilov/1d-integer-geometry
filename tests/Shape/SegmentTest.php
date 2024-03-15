<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Shape;

use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Tests\AbstractTestCase;

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
}
