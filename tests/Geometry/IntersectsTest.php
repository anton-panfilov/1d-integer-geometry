<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Geometry;

use AP\Geometry\Int1D\Geometry\Intersects;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;
use AP\Geometry\Int1D\Tests\AbstractTestCase;

final class IntersectsTest extends AbstractTestCase
{
    public function testIntersectsPoints(): void
    {
        $point_1      = new Point(value: 1);
        $point_2      = new Point(value: 2);
        $point_1_copy = new Point(value: 1);
        $point_5      = new Point(value: 5);
        $point_m5     = new Point(value: 1);
        $point_0      = new Point(value: 0);

        $this->assertTrue(Intersects::intersectsPoints($point_0, $point_0));
        $this->assertTrue(Intersects::intersectsPoints($point_1, $point_1));
        $this->assertTrue(Intersects::intersectsPoints($point_1, $point_1_copy));
        $this->assertTrue(Intersects::intersectsPoints($point_m5, $point_m5));
        $this->assertFalse(Intersects::intersectsPoints($point_1, $point_2));
        $this->assertFalse(Intersects::intersectsPoints($point_m5, $point_5));
    }

    public function testIntersectsPointAndSegment(): void
    {
        $point_m2 = new Point(value: -2);
        $point_0  = new Point(value: 0);
        $point_1  = new Point(value: 1);
        $point_2  = new Point(value: 2);
        $point_3  = new Point(value: 3);
        $point_4  = new Point(value: 4);

        $segment_1_1  = new Segment($point_1, $point_1);
        $segment_1_3  = new Segment($point_1, $point_3);
        $segment_3_1  = new Segment($point_1, $point_3);
        $segment_m2_1 = new Segment($point_m2, $point_1);
        $segment_1_m2 = new Segment($point_1, $point_m2);

        $this->assertFalse(Intersects::intersectsPointAndSegment($point_m2, $segment_1_3));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_0, $segment_1_3));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_1, $segment_1_3));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_2, $segment_1_3));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_3, $segment_1_3));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_4, $segment_1_3));

        $this->assertFalse(Intersects::intersectsPointAndSegment($point_m2, $segment_3_1));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_0, $segment_3_1));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_1, $segment_3_1));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_2, $segment_3_1));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_3, $segment_3_1));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_4, $segment_3_1));

        $this->assertTrue(Intersects::intersectsPointAndSegment($point_m2, $segment_m2_1));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_0, $segment_m2_1));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_1, $segment_m2_1));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_2, $segment_m2_1));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_3, $segment_m2_1));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_4, $segment_m2_1));

        $this->assertTrue(Intersects::intersectsPointAndSegment($point_m2, $segment_1_m2));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_0, $segment_1_m2));
        $this->assertTrue(Intersects::intersectsPointAndSegment($point_1, $segment_1_m2));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_2, $segment_1_m2));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_3, $segment_1_m2));
        $this->assertFalse(Intersects::intersectsPointAndSegment($point_4, $segment_1_m2));

        $this->assertTrue(Intersects::intersectsPointAndSegment($point_1, $segment_1_1));
    }

    public function testIntersectsPointAndVector(): void
    {
        $point_m10 = new Point(value: -10);
        $point_m2  = new Point(value: -2);
        $point_0   = new Point(value: 0);
        $point_1   = new Point(value: 1);
        $point_10  = new Point(value: 10);

        $vector_0_pos  = new Vector($point_0, true);
        $vector_0_neg  = new Vector($point_0, false);
        $vector_10_pos = new Vector($point_10, true);
        $vector_10_neg = new Vector($point_10, false);

        $this->assertFalse(Intersects::intersectsPointAndVector($point_m10, $vector_0_pos));
        $this->assertFalse(Intersects::intersectsPointAndVector($point_m2, $vector_0_pos));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_0, $vector_0_pos));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_1, $vector_0_pos));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_10, $vector_0_pos));

        $this->assertTrue(Intersects::intersectsPointAndVector($point_m10, $vector_0_neg));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_m2, $vector_0_neg));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_0, $vector_0_neg));
        $this->assertFalse(Intersects::intersectsPointAndVector($point_1, $vector_0_neg));
        $this->assertFalse(Intersects::intersectsPointAndVector($point_10, $vector_0_neg));

        $this->assertFalse(Intersects::intersectsPointAndVector($point_m10, $vector_10_pos));
        $this->assertFalse(Intersects::intersectsPointAndVector($point_m2, $vector_10_pos));
        $this->assertFalse(Intersects::intersectsPointAndVector($point_0, $vector_10_pos));
        $this->assertFalse(Intersects::intersectsPointAndVector($point_1, $vector_10_pos));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_10, $vector_10_pos));

        $this->assertTrue(Intersects::intersectsPointAndVector($point_m10, $vector_10_neg));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_m2, $vector_10_neg));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_0, $vector_10_neg));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_1, $vector_10_neg));
        $this->assertTrue(Intersects::intersectsPointAndVector($point_10, $vector_10_neg));
    }

    public function testIntersectsSegments(): void
    {
        $segment_2_5   = new Segment(new Point(value: 2), new Point(value: 5));
        $segment_5_2   = new Segment(new Point(value: 5), new Point(value: 2));
        $segment_1_3   = new Segment(new Point(value: 1), new Point(value: 3));
        $segment_1_2   = new Segment(new Point(value: 1), new Point(value: 2));
        $segment_m3_0  = new Segment(new Point(value: -3), new Point(value: 0));
        $segment_3_7   = new Segment(new Point(value: 3), new Point(value: 7));
        $segment_10_11 = new Segment(new Point(value: 10), new Point(value: 11));
        $segment_2_2   = new Segment(new Point(value: 2), new Point(value: 2));

        $this->assertTrue(Intersects::intersectsSegments($segment_2_5, $segment_5_2));
        $this->assertTrue(Intersects::intersectsSegments($segment_5_2, $segment_5_2));
        $this->assertTrue(Intersects::intersectsSegments($segment_1_3, $segment_5_2));
        $this->assertTrue(Intersects::intersectsSegments($segment_1_2, $segment_5_2));
        $this->assertFalse(Intersects::intersectsSegments($segment_m3_0, $segment_5_2));
        $this->assertTrue(Intersects::intersectsSegments($segment_3_7, $segment_5_2));
        $this->assertFalse(Intersects::intersectsSegments($segment_10_11, $segment_5_2));

        $this->assertTrue(Intersects::intersectsSegments($segment_2_5, $segment_2_5));
        $this->assertTrue(Intersects::intersectsSegments($segment_5_2, $segment_2_5));
        $this->assertTrue(Intersects::intersectsSegments($segment_1_3, $segment_2_5));
        $this->assertTrue(Intersects::intersectsSegments($segment_1_2, $segment_2_5));
        $this->assertFalse(Intersects::intersectsSegments($segment_m3_0, $segment_2_5));
        $this->assertTrue(Intersects::intersectsSegments($segment_3_7, $segment_2_5));
        $this->assertFalse(Intersects::intersectsSegments($segment_10_11, $segment_2_5));

        $this->assertTrue(Intersects::intersectsSegments($segment_2_2, $segment_2_2));
        $this->assertFalse(Intersects::intersectsSegments($segment_2_2, $segment_3_7));
    }

    public function testIntersectsSegmentAndVector(): void
    {
        $point_1 = new Point(1);
        $point_2 = new Point(2);
        $point_3 = new Point(3);
        $point_4 = new Point(4);
        $point_7 = new Point(7);

        $vector_3_pos = new Vector($point_3, true);
        $vector_3_neg = new Vector($point_3, false);

        $segment_1_2 = new Segment($point_1, $point_2);
        $segment_1_3 = new Segment($point_1, $point_3);
        $segment_1_4 = new Segment($point_1, $point_4);

        $segment_2_1 = new Segment($point_2, $point_1);
        $segment_3_1 = new Segment($point_3, $point_1);
        $segment_4_1 = new Segment($point_4, $point_1);

        $segment_7_2 = new Segment($point_7, $point_2);
        $segment_7_3 = new Segment($point_7, $point_3);
        $segment_7_4 = new Segment($point_7, $point_4);

        $segment_2_7 = new Segment($point_2, $point_7);
        $segment_3_7 = new Segment($point_3, $point_7);
        $segment_4_7 = new Segment($point_4, $point_7);

        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_1_2, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1_3, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1_4, $vector_3_pos));

        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_2_1, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_3_1, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_4_1, $vector_3_pos));

        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_7_2, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_7_3, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_7_4, $vector_3_pos));

        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_2_7, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_3_7, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_4_7, $vector_3_pos));


        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1_2, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1_3, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1_4, $vector_3_neg));

        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_2_1, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_3_1, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_4_1, $vector_3_neg));

        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_7_2, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_7_3, $vector_3_neg));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_7_4, $vector_3_neg));

        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_2_7, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_3_7, $vector_3_neg));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_4_7, $vector_3_neg));
    }

    public function testIntersectsVectors(): void
    {
        $point_3  = new Point(3);
        $point_m3 = new Point(-3);

        $vector_3_pos = new Vector($point_3, true);
        $vector_3_neg = new Vector($point_3, false);

        $vector_m3_pos = new Vector($point_m3, true);
        $vector_m3_neg = new Vector($point_m3, false);

        $this->assertTrue(Intersects::intersectsVectors($vector_3_neg, $vector_3_pos));
        $this->assertTrue(Intersects::intersectsVectors($vector_3_pos, $vector_3_neg));
        $this->assertTrue(Intersects::intersectsVectors($vector_m3_pos, $vector_m3_neg));
        $this->assertTrue(Intersects::intersectsVectors($vector_3_pos, $vector_m3_pos));
        $this->assertTrue(Intersects::intersectsVectors($vector_3_neg, $vector_m3_neg));
        $this->assertFalse(Intersects::intersectsVectors($vector_m3_neg, $vector_3_pos));
        $this->assertFalse(Intersects::intersectsVectors($vector_3_pos, $vector_m3_neg));
    }
}
