<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Geometry;

use AP\Geometry\Int1D\Geometry\Exclude;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Tests\AbstractTestCase;
use function AP\Geometry\Int1D\Tests\Helpers\all;
use function AP\Geometry\Int1D\Tests\Helpers\p;
use function AP\Geometry\Int1D\Tests\Helpers\s;
use function AP\Geometry\Int1D\Tests\Helpers\vn;
use function AP\Geometry\Int1D\Tests\Helpers\vp;

final class ExcludeTest extends AbstractTestCase
{
    final protected static function assertExcludeTest(
        AbstractShape|ShapesCollection       $original,
        AbstractShape|ShapesCollection       $exclude,
        AbstractShape|ShapesCollection|array $expected,
    ): void
    {
        self::assertShapesCollection(
            expected: $expected,
            actual: Exclude::exclude(
                exclude: $exclude,
                original: $original
            )
        );
    }

    final protected static function assertExceptionNoIntersectsForExclude(
        AbstractShape|ShapesCollection $original,
        AbstractShape|ShapesCollection $exclude,
    ): void
    {
        self::assertExceptionNoIntersects(function () use ($original, $exclude) {
            Exclude::exclude(
                exclude: $exclude,
                original: $original
            );
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // FROM POINT

    public function testExcludePointFromPoint(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: p(4), exclude: p(3));

        self::assertExcludeTest(original: p(3), exclude: p(3), expected: []);
    }

    public function testExcludeSegmentFromPoint(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: p(0), exclude: s(6, 10));
        $this->assertExceptionNoIntersectsForExclude(original: p(0), exclude: s(-100, -1));
        $this->assertExceptionNoIntersectsForExclude(original: p(100), exclude: s(-200, 99));

        self::assertExcludeTest(original: p(0), exclude: s(-1, 1), expected: []);
    }

    public function testExcludeVectorFromPoint(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: p(0), exclude: vp(1));
        $this->assertExceptionNoIntersectsForExclude(original: p(0), exclude: vn(-1));
        $this->assertExceptionNoIntersectsForExclude(original: p(100), exclude: vn(99));

        self::assertExcludeTest(original: p(0), exclude: vp(-5), expected: []);
        self::assertExcludeTest(original: p(0), exclude: vn(100), expected: []);
    }

    public function testExcludeAllFromPoint(): void
    {
        self::assertExcludeTest(original: p(0), exclude: all(), expected: []);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // FROM SEGMENT

    public function testExcludePointFromSegment(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: s(2, 4), exclude: p(-4));
        $this->assertExceptionNoIntersectsForExclude(original: s(2, 4), exclude: p(0));
        $this->assertExceptionNoIntersectsForExclude(original: s(2, 4), exclude: p(1));
        $this->assertExceptionNoIntersectsForExclude(original: s(2, 4), exclude: p(10));

        self::assertExcludeTest(original: s(2, 4), exclude: p(2), expected: s(3, 4));
        self::assertExcludeTest(original: s(2, 10), exclude: p(3), expected: [p(2), s(4, 10)]);
        self::assertExcludeTest(original: s(2, 10), exclude: p(7), expected: [s(2, 6), s(8, 10)]);
        self::assertExcludeTest(original: s(2, 2), exclude: p(2), expected: []);
    }

    public function testExcludeSegmentFromSegment(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: s(1, 2), exclude: s(10, 30));
        $this->assertExceptionNoIntersectsForExclude(original: s(1, 2), exclude: s(-1, 0));

        self::assertExcludeTest(original: s(10, 30), exclude: s(9, 11), expected: s(12, 30));
        self::assertExcludeTest(original: s(9, 11), exclude: s(10, 30), expected: p(9));
        self::assertExcludeTest(original: s(10, 30), exclude: s(11, 20), expected: [p(10), s(21, 30)]);

        self::assertExcludeTest(original: s(10, 30), exclude: s(12, 20), expected: [s(10, 11), s(21, 30)]);
        self::assertExcludeTest(original: s(10, 30), exclude: s(20, 12), expected: [s(10, 11), s(21, 30)]);
        self::assertExcludeTest(original: s(30, 10), exclude: s(12, 20), expected: [s(10, 11), s(21, 30)]);
        self::assertExcludeTest(original: s(30, 10), exclude: s(20, 12), expected: [s(10, 11), s(21, 30)]);

        self::assertExcludeTest(original: s(-10, 10), exclude: s(-9, 5), expected: [p(-10), s(6, 10)]);
        self::assertExcludeTest(original: s(2, 10), exclude: s(7, 7), expected: [s(2, 6), s(8, 10)]);
        self::assertExcludeTest(original: s(10, 2), exclude: s(7, 7), expected: [s(2, 6), s(8, 10)]);
        self::assertExcludeTest(original: s(2, 2), exclude: s(2, 2), expected: []);
    }

    public function testExcludeVectorFromSegment(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: s(3, 5), exclude: vp(6));
        $this->assertExceptionNoIntersectsForExclude(original: s(5, 3), exclude: vp(6));

        self::assertExcludeTest(original: s(3, 5), exclude: vp(2), expected: []);
        self::assertExcludeTest(original: s(3, 5), exclude: vp(3), expected: []);
        self::assertExcludeTest(original: s(3, 5), exclude: vp(4), expected: p(3));
        self::assertExcludeTest(original: s(3, 5), exclude: vp(5), expected: s(3, 4));

        self::assertExcludeTest(original: s(5, 3), exclude: vp(2), expected: []);
        self::assertExcludeTest(original: s(5, 3), exclude: vp(3), expected: []);
        self::assertExcludeTest(original: s(5, 3), exclude: vp(4), expected: p(3));
        self::assertExcludeTest(original: s(5, 3), exclude: vp(5), expected: s(3, 4));

        self::assertExcludeTest(original: s(3, 5), exclude: vn(6), expected: []);
        self::assertExcludeTest(original: s(3, 5), exclude: vn(5), expected: []);
        self::assertExcludeTest(original: s(3, 5), exclude: vn(4), expected: p(5));
        self::assertExcludeTest(original: s(3, 5), exclude: vn(3), expected: s(4, 5));
    }

    public function testExcludeAllFromSegment(): void
    {
        self::assertExcludeTest(original: s(3, 5), exclude: all(), expected: []);
        self::assertExcludeTest(original: s(5, 3), exclude: all(), expected: []);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // FROM VECTOR

    public function testExcludePointFromVector(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: vp(10), exclude: p(1));
        $this->assertExceptionNoIntersectsForExclude(original: vn(10), exclude: p(12));

        self::assertExcludeTest(original: vp(10), exclude: p(10), expected: vp(11));
        self::assertExcludeTest(original: vp(10), exclude: p(11), expected: [p(10), vp(12)]);
        self::assertExcludeTest(original: vp(10), exclude: p(111), expected: [s(10, 110), vp(112)]);

        self::assertExcludeTest(original: vn(10), exclude: p(10), expected: vn(9));
        self::assertExcludeTest(original: vn(10), exclude: p(9), expected: [p(10), vn(8)]);
        self::assertExcludeTest(original: vn(10), exclude: p(0), expected: [s(1, 10), vn(-1)]);
    }

    public function testExcludeSegmentFromVector(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: vp(3), exclude: s(-10, 2));
        $this->assertExceptionNoIntersectsForExclude(original: vn(10), exclude: s(20, 30));

        self::assertExcludeTest(original: vp(2), exclude: s(1, 6), expected: vp(7));
        self::assertExcludeTest(original: vp(2), exclude: s(2, 6), expected: vp(7));
        self::assertExcludeTest(original: vp(2), exclude: s(3, 6), expected: [p(2), vp(7)]);
        self::assertExcludeTest(original: vp(2), exclude: s(4, 6), expected: [s(2, 3), vp(7)]);
        self::assertExcludeTest(original: vp(2), exclude: s(5, 6), expected: [s(2, 4), vp(7)]);
        self::assertExcludeTest(original: vp(2), exclude: s(6, 6), expected: [s(2, 5), vp(7)]);

        self::assertExcludeTest(original: vp(2), exclude: s(6, 1), expected: vp(7));
        self::assertExcludeTest(original: vp(2), exclude: s(6, 2), expected: vp(7));
        self::assertExcludeTest(original: vp(2), exclude: s(6, 3), expected: [p(2), vp(7)]);
        self::assertExcludeTest(original: vp(2), exclude: s(6, 4), expected: [s(2, 3), vp(7)]);
        self::assertExcludeTest(original: vp(2), exclude: s(6, 5), expected: [s(2, 4), vp(7)]);

        self::assertExcludeTest(original: vn(6), exclude: s(3, 6), expected: vn(2));
        self::assertExcludeTest(original: vn(6), exclude: s(3, 5), expected: [vn(2), p(6)]);
        self::assertExcludeTest(original: vn(6), exclude: s(3, 4), expected: [vn(2), s(5, 6)]);
    }

    public function testExcludeVectorFromVector(): void
    {
        $this->assertExceptionNoIntersectsForExclude(original: vn(3), exclude: vp(5));
        $this->assertExceptionNoIntersectsForExclude(original: vn(-5), exclude: vp(5));
        $this->assertExceptionNoIntersectsForExclude(original: vn(-7), exclude: vp(0));

        self::assertExcludeTest(original: vp(5), exclude: vp(3), expected: []);
        self::assertExcludeTest(original: vp(3), exclude: vp(4), expected: p(3));
        self::assertExcludeTest(original: vp(3), exclude: vp(5), expected: s(3, 4));
        self::assertExcludeTest(original: vn(3), exclude: vn(4), expected: []);
    }

    public function testExcludeAllFromVector(): void
    {
        self::assertExcludeTest(original: vn(3), exclude: all(), expected: []);
        self::assertExcludeTest(original: vp(5), exclude: all(), expected: []);
        self::assertExcludeTest(original: vn(0), exclude: all(), expected: []);
        self::assertExcludeTest(original: vp(0), exclude: all(), expected: []);
        self::assertExcludeTest(original: vn(-2), exclude: all(), expected: []);
        self::assertExcludeTest(original: vp(-100), exclude: all(), expected: []);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // FROM ALL

    public function testExcludePointFromAll(): void
    {
        self::assertExcludeTest(original: all(), exclude: p(7), expected: [vn(6), vp(8)]);
    }

    public function testExcludeSegmentFromAll(): void
    {
        self::assertExcludeTest(original: all(), exclude: s(-10, 10), expected: [vn(-11), vp(11)]);
        self::assertExcludeTest(original: all(), exclude: s(10, -10), expected: [vn(-11), vp(11)]);
        self::assertExcludeTest(original: all(), exclude: s(5, 5), expected: [vn(4), vp(6)]);
    }

    public function testExcludeVectorFromAll(): void
    {
        self::assertExcludeTest(original: all(), exclude: vp(7), expected: vn(6));
        self::assertExcludeTest(original: all(), exclude: vn(7), expected: vp(8));
    }

    public function testExcludeAllFromAll(): void
    {
        self::assertExcludeTest(original: all(), exclude: all(), expected: []);
    }
}
