<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Geometry;

use AP\Geometry\Int1D\Geometry\Exclude;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\Vector;
use AP\Geometry\Int1D\Exception\NoIntersectsException;
use AP\Geometry\Int1D\Tests\AbstractTestCase;
use Exception;

final class ExcludeTest extends AbstractTestCase
{
    /**
     * @throws NoIntersectsException
     */
    public function testExcludeSegmentFromSegment(): void
    {
        $segment_10_30 = new Segment(new Point(value: 10), new Point(value: 30));

        $segment_9_11  = new Segment(new Point(value: 9), new Point(value: 11));
        $segment_1_2   = new Segment(new Point(value: 1), new Point(value: 2));
        $segment_11_20 = new Segment(new Point(value: 11), new Point(value: 20));
        $segment_12_20 = new Segment(new Point(value: 12), new Point(value: 20));

        $NoIntersectsException = false;
        try {
            Exclude::excludeSegmentFromSegment(
                excludeSegment: $segment_10_30,
                originalSegment: $segment_1_2,
            );
        } catch (NoIntersectsException) {
            $NoIntersectsException = true;
        } catch (Exception) {
        }
        $this->assertTrue($NoIntersectsException);


        $this->assertShapesCollection(
            [
                new Segment(new Point(value: 12), new Point(value: 30)),
            ],
            Exclude::excludeSegmentFromSegment(
                excludeSegment: $segment_10_30,
                originalSegment: $segment_9_11,
            )
        );


        $this->assertShapesCollection(
            [
                new Segment(new Point(value: 21), new Point(value: 30)),
                new Point(value: 10),
            ],
            Exclude::excludeSegmentFromSegment(
                excludeSegment: $segment_10_30,
                originalSegment: $segment_11_20,
            )
        );

        $this->assertShapesCollection(
            [
                new Segment(new Point(value: 10), new Point(value: 11)),
                new Segment(new Point(value: 21), new Point(value: 30)),
            ],
            Exclude::excludeSegmentFromSegment(
                excludeSegment: $segment_10_30,
                originalSegment: $segment_12_20,
            )
        );

    }

    /**
     * @throws NoIntersectsException
     */
    public function testExcludeVectorFromVector(): void
    {
        $point_3 = new Point(3);
        $point_4 = new Point(4);
        $point_5 = new Point(5);

        $vector_3_p = new Vector($point_3, true);
        $vector_4_p = new Vector($point_4, true);
        $vector_5_p = new Vector($point_5, true);

        $vector_3_n = new Vector($point_3, false);
        $vector_4_n = new Vector($point_4, false);
        $vector_5_n = new Vector($point_5, false);

        $NoIntersectsException = false;
        try {
            Exclude::excludeVectorFromVector(
                excludeVector: $vector_5_p,
                originalVector: $vector_3_n,
            );
        } catch (NoIntersectsException) {
            $NoIntersectsException = true;
        } catch (Exception) {
        }
        $this->assertTrue($NoIntersectsException);


        $this->assertShapesCollection(
            [],
            Exclude::excludeVectorFromVector(
                excludeVector: $vector_3_p,
                originalVector: $vector_5_p,
            )
        );

        $this->assertShapesCollection(
            [
                new Segment($point_3, $point_4)
            ],
            Exclude::excludeVectorFromVector(
                excludeVector: $vector_5_p,
                originalVector: $vector_3_p,
            )
        );

        $this->assertShapesCollection([], Exclude::excludeVectorFromVector(
            excludeVector: $vector_4_n,
            originalVector: $vector_3_n
        ));
    }

}
