<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Geometry;

use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Geometry\Sort;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;
use AP\Geometry\Int1D\Tests\AbstractTestCase;

final class GeometryTest extends AbstractTestCase
{
    public function testSortByMin(): void
    {
        $point_m10     = new Point(-10);
        $p0       = new Point(0);
        $p1       = new Point(1);
        $point_5       = new Point(5);
        $point_7       = new Point(7);
        $segment_1_7   = new Segment($p1, $point_7);
        $segment_0_m10 = new Segment($p0, $point_m10);
        $segment_m10_0 = new Segment($point_m10, $p0);
        $vector_0_p    = new Vector($p0, true);
        $vector_7_p    = new Vector($point_7, true);
        $vector_0_n    = new Vector($p0, false);

        // points

        $this->assertEquals(
            [
                $point_m10,
                $p0,
                $p1,
                $point_5,
                $point_7,
            ],
            Sort::sortByMin(new ShapesCollection([
                $p1,
                $point_7,
                $p0,
                $point_5,
                $point_m10,
            ]))->all()
        );

        // segments

        $this->assertEquals(
            [
                $segment_1_7,
                $point_5
            ],
            Sort::sortByMin(new ShapesCollection([
                $point_5,
                $segment_1_7,
            ]))->all()
        );

        $this->assertEquals(
            [
                $segment_0_m10,
                $segment_m10_0,
                $segment_1_7,
            ],
            Sort::sortByMin(new ShapesCollection([
                $segment_0_m10,
                $segment_1_7,
                $segment_m10_0,
            ]))->all()
        );

        $this->assertEquals(
            [
                $segment_m10_0,
                $segment_0_m10,
                $segment_1_7,
            ],
            Sort::sortByMin(new ShapesCollection([

                $segment_m10_0,
                $segment_1_7,
                $segment_0_m10,
            ]))->all()
        );

        // vectors

        $this->assertEquals(
            [
                $vector_0_n,
                $vector_0_p,
            ],
            Sort::sortByMin(new ShapesCollection([
                $vector_0_n,
                $vector_0_p,
            ]))->all()
        );

        $this->assertEquals(
            [
                $vector_0_n,
                $vector_0_p,
            ],
            Sort::sortByMin(new ShapesCollection([
                $vector_0_p,
                $vector_0_n,
            ]))->all()
        );

        $this->assertEquals(
            [
                $vector_0_p,
                $vector_7_p,
            ],
            Sort::sortByMin(new ShapesCollection([
                $vector_0_p,
                $vector_7_p,
            ]))->all()
        );

        $this->assertEquals(
            [
                $vector_0_p,
                $vector_7_p,
            ],
            Sort::sortByMin(new ShapesCollection([
                $vector_7_p,
                $vector_0_p,
            ]))->all()
        );

        // mix

        $this->assertEquals(
            [
                $vector_0_n,
                $vector_0_p,
                $segment_1_7,
                $point_5,
            ],
            Sort::sortByMin(new ShapesCollection([
                $point_5,
                $segment_1_7,
                $vector_0_p,
                $vector_0_n,
            ]))->all()
        );
    }

    public function testSortByMinAndLength(): void
    {
        $p0 = new Point(0);
        $p1 = new Point(1);
        $point_5 = new Point(5);

        $segment_0_1 = new Segment($p0, $p1);
        $segment_1_0 = new Segment($p1, $p0);

        $segment_0_5 = new Segment($p0, $point_5);

        $vector_0_p        = new Vector($p0, true);
        $vector_0_p_second = new Vector($p0, true);

        // same segments

        $this->assertEquals(
            [
                $segment_0_1,
                $segment_1_0,
            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $segment_0_1,
                $segment_1_0,
            ]))->all()
        );

        $this->assertEquals(
            [
                $segment_1_0,
                $segment_0_1,

            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $segment_1_0,
                $segment_0_1,
            ]))->all()
        );

        // 2 same + one diff

        $this->assertEquals(
            [
                $segment_1_0,
                $segment_0_1,
                $segment_0_5,

            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $segment_0_5,
                $segment_1_0,
                $segment_0_1,
            ]))->all()
        );

        $this->assertEquals(
            [
                $segment_1_0,
                $segment_0_1,
                $segment_0_5,

            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $segment_1_0,
                $segment_0_1,
                $segment_0_5,
            ]))->all()
        );

        $this->assertEquals(
            [
                $segment_1_0,
                $segment_0_1,
                $segment_0_5,

            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $segment_1_0,
                $segment_0_5,
                $segment_0_1,
            ]))->all()
        );

        // same vectors

        $this->assertEquals(
            [
                $vector_0_p,
                $vector_0_p_second,
            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $vector_0_p,
                $vector_0_p_second,
            ]))->all()
        );

        $this->assertEquals(
            [
                $vector_0_p_second,
                $vector_0_p,
            ],
            Sort::sortByMinAndLength(new ShapesCollection([
                $vector_0_p_second,
                $vector_0_p,
            ]))->all()
        );
    }

}
