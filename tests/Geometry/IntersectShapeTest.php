<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Geometry;

use AP\Geometry\Int1D\Geometry\Intersects;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Tests\AbstractTestCase;
use function AP\Geometry\Int1D\Tests\Helpers\all;
use function AP\Geometry\Int1D\Tests\Helpers\p;
use function AP\Geometry\Int1D\Tests\Helpers\s;
use function AP\Geometry\Int1D\Tests\Helpers\vn;
use function AP\Geometry\Int1D\Tests\Helpers\vp;

final class IntersectShapeTest extends AbstractTestCase
{
    final protected static function assertIntersectShapeForTest(
        AbstractShape $shape1,
        AbstractShape $shape2,
        AbstractShape $expected,
    ): void
    {
        AbstractTestCase::assertEquals(
            expected: $expected->normalize(),

            // should be normalized, please, no double normalize!
            actual: Intersects::getIntersectsShape(
                shape1: $shape1,
                shape2: $shape2
            ),
        );
    }

    final protected static function assertExceptionNoIntersectsForExclude(
        AbstractShape|ShapesCollection $shape1,
        AbstractShape|ShapesCollection $shape2,
    ): void
    {
        self::assertExceptionNoIntersects(function () use ($shape1, $shape2) {
            Intersects::getIntersectsShape(
                shape1: $shape1,
                shape2: $shape2,
            );
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // POINT and X

    public function testIntersectShapeForPointAndPoint(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: p(4), shape2: p(3));

        self::assertIntersectShapeForTest(shape1: p(3), shape2: p(3), expected: p(3));
    }

    public function testIntersectShapeForSegmentAndPoint(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: p(0), shape2: s(6, 10));
        $this->assertExceptionNoIntersectsForExclude(shape1: p(0), shape2: s(-100, -1));
        $this->assertExceptionNoIntersectsForExclude(shape1: p(100), shape2: s(-200, 99));

        self::assertIntersectShapeForTest(shape1: p(0), shape2: s(-1, 1), expected: p(0));
    }

    public function testIntersectShapeForVectorAndPoint(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: p(0), shape2: vp(1));
        $this->assertExceptionNoIntersectsForExclude(shape1: p(0), shape2: vn(-1));
        $this->assertExceptionNoIntersectsForExclude(shape1: p(100), shape2: vn(99));

        self::assertIntersectShapeForTest(shape1: p(0), shape2: vp(-5), expected: p(0));
        self::assertIntersectShapeForTest(shape1: p(0), shape2: vn(100), expected: p(0));
    }

    public function testIntersectShapeForAllAndPoint(): void
    {
        self::assertIntersectShapeForTest(shape1: p(0), shape2: all(), expected: p(0));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SEGMENT and X

    public function testIntersectShapeForPointAndSegment(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: s(2, 4), shape2: p(-4));
        $this->assertExceptionNoIntersectsForExclude(shape1: s(2, 4), shape2: p(0));
        $this->assertExceptionNoIntersectsForExclude(shape1: s(2, 4), shape2: p(1));
        $this->assertExceptionNoIntersectsForExclude(shape1: s(2, 4), shape2: p(10));

        self::assertIntersectShapeForTest(shape1: s(2, 4), shape2: p(2), expected: p(2));
        self::assertIntersectShapeForTest(shape1: s(2, 10), shape2: p(3), expected: p(3));
        self::assertIntersectShapeForTest(shape1: s(2, 10), shape2: p(10), expected: p(10));
        self::assertIntersectShapeForTest(shape1: s(2, 2), shape2: p(2), expected: p(2));
    }

    public function testIntersectShapeForSegmentAndSegment(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: s(1, 2), shape2: s(10, 30));
        $this->assertExceptionNoIntersectsForExclude(shape1: s(1, 2), shape2: s(-1, 0));

        self::assertIntersectShapeForTest(shape1: s(0, 10), shape2: s(10, 20), expected: p(10));
        self::assertIntersectShapeForTest(shape1: s(0, 10), shape2: s(7, 20), expected: s(7, 10));
        self::assertIntersectShapeForTest(shape1: s(0, 10), shape2: s(0, 10), expected: s(0, 10));
        self::assertIntersectShapeForTest(shape1: s(0, 10), shape2: s(2, 7), expected: s(2, 7));
        self::assertIntersectShapeForTest(shape1: s(2, 7), shape2: s(0, 10), expected: s(2, 7));
    }

    public function testIntersectShapeForVectorAndSegment(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: s(3, 5), shape2: vp(6));
        $this->assertExceptionNoIntersectsForExclude(shape1: s(5, 3), shape2: vp(6));

        self::assertIntersectShapeForTest(shape1: s(1, 2), shape2: vp(2), expected: p(2));
        self::assertIntersectShapeForTest(shape1: s(1, 3), shape2: vp(2), expected: s(2, 3));
        self::assertIntersectShapeForTest(shape1: s(2, 100), shape2: vp(2), expected: s(2, 100));
        self::assertIntersectShapeForTest(shape1: s(3, 100), shape2: vp(2), expected: s(3, 100));

        self::assertIntersectShapeForTest(shape1: s(2, 10), shape2: vn(2), expected: p(2));
        self::assertIntersectShapeForTest(shape1: s(1, 10), shape2: vn(2), expected: s(1, 2));
        self::assertIntersectShapeForTest(shape1: s(0, 2), shape2: vn(2), expected: s(0, 2));
        self::assertIntersectShapeForTest(shape1: s(0, 1), shape2: vn(2), expected: s(0, 1));
    }

    public function testIntersectShapeForAllAndSegment(): void
    {
        self::assertIntersectShapeForTest(shape1: s(3, 5), shape2: all(), expected: s(3, 5));
        self::assertIntersectShapeForTest(shape1: s(5, 3), shape2: all(), expected: s(3, 5));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // VECTOR and X

    public function testIntersectShapeForPointAndVector(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: vp(10), shape2: p(1));
        $this->assertExceptionNoIntersectsForExclude(shape1: vn(10), shape2: p(12));

        self::assertIntersectShapeForTest(shape1: vp(10), shape2: p(10), expected: p(10));
        self::assertIntersectShapeForTest(shape1: vp(10), shape2: p(111), expected: p(111));

        self::assertIntersectShapeForTest(shape1: vn(10), shape2: p(10), expected: p(10));
        self::assertIntersectShapeForTest(shape1: vn(10), shape2: p(0), expected: p(0));
    }

    public function testIntersectShapeForSegmentAndVector(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: vp(3), shape2: s(-10, 2));
        $this->assertExceptionNoIntersectsForExclude(shape1: vn(10), shape2: s(20, 30));

        self::assertIntersectShapeForTest(shape1: vp(2), shape2: s(1, 2), expected: p(2));
        self::assertIntersectShapeForTest(shape1: vp(2), shape2: s(1, 6), expected: s(2, 6));
        self::assertIntersectShapeForTest(shape1: vp(2), shape2: s(5, 6), expected: s(5, 6));

        self::assertIntersectShapeForTest(shape1: vn(7), shape2: s(1, 5), expected: s(1, 5));
        self::assertIntersectShapeForTest(shape1: vn(7), shape2: s(1, 7), expected: s(1, 7));
        self::assertIntersectShapeForTest(shape1: vn(7), shape2: s(1, 10), expected: s(1, 7));
        self::assertIntersectShapeForTest(shape1: vn(7), shape2: s(7, 10), expected: p(7));
    }

    public function testIntersectShapeForVectorAndVector(): void
    {
        $this->assertExceptionNoIntersectsForExclude(shape1: vn(3), shape2: vp(5));
        $this->assertExceptionNoIntersectsForExclude(shape1: vn(-5), shape2: vp(5));
        $this->assertExceptionNoIntersectsForExclude(shape1: vn(-7), shape2: vp(0));


        self::assertIntersectShapeForTest(shape1: vp(5), shape2: vp(3), expected: vp(5));
        self::assertIntersectShapeForTest(shape1: vn(5), shape2: vn(3), expected: vn(3));

        self::assertIntersectShapeForTest(shape1: vp(3), shape2: vn(10), expected: s(3, 10));
        self::assertIntersectShapeForTest(shape1: vp(3), shape2: vn(3), expected: p(3));
    }

    public function testIntersectShapeForAllAndVector(): void
    {
        self::assertIntersectShapeForTest(shape1: vp(3), shape2: all(), expected: vp(3));
        self::assertIntersectShapeForTest(shape1: vn(0), shape2: all(), expected: vn(0));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ALL and X

    public function testIntersectShapeForPointAndAll(): void
    {
        self::assertIntersectShapeForTest(shape1: all(), shape2: p(7), expected: p(7));
    }

    public function testIntersectShapeForSegmentAndAll(): void
    {
        self::assertIntersectShapeForTest(shape1: all(), shape2: s(-10, 10), expected: s(-10, 10));
        self::assertIntersectShapeForTest(shape1: all(), shape2: s(10, -10), expected: s(10, -10));
        self::assertIntersectShapeForTest(shape1: all(), shape2: s(5, 5), expected: s(5, 5));
    }

    public function testIntersectShapeForVectorAndAll(): void
    {
        self::assertIntersectShapeForTest(shape1: all(), shape2: vp(7), expected: vp(7));
        self::assertIntersectShapeForTest(shape1: all(), shape2: vn(7), expected: vn(7));
    }

    public function testIntersectShapeForAllAndAll(): void
    {
        self::assertIntersectShapeForTest(shape1: all(), shape2: all(), expected: all());
    }
}
