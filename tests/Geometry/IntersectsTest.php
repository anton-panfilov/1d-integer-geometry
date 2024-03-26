<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Geometry;

use AP\Geometry\Int1D\Geometry\Intersects;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Tests\AbstractTestCase;
use function AP\Geometry\Int1D\Tests\Helpers\all;
use function AP\Geometry\Int1D\Tests\Helpers\p;
use function AP\Geometry\Int1D\Tests\Helpers\s;
use function AP\Geometry\Int1D\Tests\Helpers\vn;
use function AP\Geometry\Int1D\Tests\Helpers\vp;

final class IntersectsTest extends AbstractTestCase
{
    protected static function assertIntersectsTrue(AbstractShape $shape1, AbstractShape $shape2): void
    {
        self::assertTrue(Intersects::intersectsShapes(shape1: $shape1, shape2: $shape2));
    }

    protected static function assertIntersectsFalse(AbstractShape $shape1, AbstractShape $shape2): void
    {
        self::assertFalse(Intersects::intersectsShapes(shape1: $shape1, shape2: $shape2));
    }

    public function testIntersectsAll(): void
    {
        self::assertIntersectsTrue(shape1: all(), shape2: p(1));
        self::assertIntersectsTrue(shape1: all(), shape2: s(1, 10));
        self::assertIntersectsTrue(shape1: all(), shape2: s(10, 1));
        self::assertIntersectsTrue(shape1: all(), shape2: vn(10));
        self::assertIntersectsTrue(shape1: all(), shape2: vn(-10));
        self::assertIntersectsTrue(shape1: all(), shape2: vn(0));
        self::assertIntersectsTrue(shape1: all(), shape2: vp(1));
        self::assertIntersectsTrue(shape1: all(), shape2: vp(-1));
        self::assertIntersectsTrue(shape1: all(), shape2: vp(0));
        self::assertIntersectsTrue(shape1: all(), shape2: all());
    }

    public function testIntersectsPoints(): void
    {
        self::assertIntersectsTrue(shape1: $p1 = p(1), shape2: $p1);
        self::assertIntersectsTrue(shape1: p(-90000000), shape2: p(-90000000));
        self::assertIntersectsTrue(shape1: p(-1), shape2: p(-1));
        self::assertIntersectsTrue(shape1: p(0), shape2: p(0));
        self::assertIntersectsTrue(shape1: p(1), shape2: p(1));

        self::assertIntersectsFalse(shape1: p(1), shape2: p(2));
        self::assertIntersectsFalse(shape1: p(-5), shape2: p(5));
    }

    public function testIntersectsPointAndSegment(): void
    {
        self::assertIntersectsFalse(shape1: p(-2), shape2: s(1, 3));
        self::assertIntersectsFalse(shape1: p(0), shape2: s(1, 3));
        self::assertIntersectsTrue(shape1: p(1), shape2: s(1, 3));
        self::assertIntersectsTrue(shape1: p(2), shape2: s(1, 3));
        self::assertIntersectsTrue(shape1: p(3), shape2: s(1, 3));
        self::assertIntersectsFalse(shape1: p(4), shape2: s(1, 3));

        self::assertIntersectsFalse(shape1: p(-2), shape2: s(3, 1));
        self::assertIntersectsFalse(shape1: p(0), shape2: s(3, 1));
        self::assertIntersectsTrue(shape1: p(1), shape2: s(3, 1));
        self::assertIntersectsTrue(shape1: p(2), shape2: s(3, 1));
        self::assertIntersectsTrue(shape1: p(3), shape2: s(3, 1));
        self::assertIntersectsFalse(shape1: p(4), shape2: s(3, 1));

        self::assertIntersectsTrue(shape1: p(-2), shape2: s(-2, 1));
        self::assertIntersectsTrue(shape1: p(0), shape2: s(-2, 1));
        self::assertIntersectsTrue(shape1: p(1), shape2: s(-2, 1));
        self::assertIntersectsFalse(shape1: p(2), shape2: s(-2, 1));
        self::assertIntersectsFalse(shape1: p(3), shape2: s(-2, 1));
        self::assertIntersectsFalse(shape1: p(4), shape2: s(-2, 1));

        self::assertIntersectsTrue(shape1: p(-2), shape2: s(1, -2));
        self::assertIntersectsTrue(shape1: p(0), shape2: s(1, -2));
        self::assertIntersectsTrue(shape1: p(1), shape2: s(1, -2));
        self::assertIntersectsFalse(shape1: p(2), shape2: s(1, -2));
        self::assertIntersectsFalse(shape1: p(3), shape2: s(1, -2));
        self::assertIntersectsFalse(shape1: p(4), shape2: s(1, -2));

        self::assertIntersectsTrue(shape1: p(1), shape2: s(1, 1));
    }

    public function testIntersectsPointsAndVectors(): void
    {
        self::assertIntersectsFalse(shape1: p(-10), shape2: vp(0));
        self::assertIntersectsFalse(shape1: p(-2), shape2: vp(0));
        self::assertIntersectsTrue(shape1: p(0), shape2: vp(0));
        self::assertIntersectsTrue(shape1: p(1), shape2: vp(0));
        self::assertIntersectsTrue(shape1: p(10), shape2: vp(0));

        self::assertIntersectsTrue(shape1: p(-10), shape2: vn(0));
        self::assertIntersectsTrue(shape1: p(-2), shape2: vn(0));
        self::assertIntersectsTrue(shape1: p(0), shape2: vn(0));
        self::assertIntersectsFalse(shape1: p(1), shape2: vn(0));
        self::assertIntersectsFalse(shape1: p(10), shape2: vn(0));

        self::assertIntersectsFalse(shape1: p(-10), shape2: vp(10));
        self::assertIntersectsFalse(shape1: p(-2), shape2: vp(10));
        self::assertIntersectsFalse(shape1: p(0), shape2: vp(10));
        self::assertIntersectsFalse(shape1: p(1), shape2: vp(10));
        self::assertIntersectsTrue(shape1: p(10), shape2: vp(10));

        self::assertIntersectsTrue(shape1: p(-10), shape2: vn(10));
        self::assertIntersectsTrue(shape1: p(-2), shape2: vn(10));
        self::assertIntersectsTrue(shape1: p(0), shape2: vn(10));
        self::assertIntersectsTrue(shape1: p(1), shape2: vn(10));
        self::assertIntersectsTrue(shape1: p(10), shape2: vn(10));
    }

    public function testIntersectsSegments(): void
    {
        self::assertIntersectsTrue(shape1: s(2, 5), shape2: s(5, 2));
        self::assertIntersectsTrue(shape1: s(5, 2), shape2: s(5, 2));
        self::assertIntersectsTrue(shape1: s(1, 3), shape2: s(5, 2));
        self::assertIntersectsTrue(shape1: s(1, 2), shape2: s(5, 2));
        self::assertIntersectsFalse(shape1: s(-3, 0), shape2: s(5, 2));
        self::assertIntersectsTrue(shape1: s(3, 7), shape2: s(5, 2));
        self::assertIntersectsFalse(shape1: s(10, 11), shape2: s(5, 2));

        self::assertIntersectsTrue(shape1: s(2, 5), shape2: s(2, 5));
        self::assertIntersectsTrue(shape1: s(5, 2), shape2: s(2, 5));
        self::assertIntersectsTrue(shape1: s(1, 3), shape2: s(2, 5));
        self::assertIntersectsTrue(shape1: s(1, 2), shape2: s(2, 5));
        self::assertIntersectsFalse(shape1: s(-3, 0), shape2: s(2, 5));
        self::assertIntersectsTrue(shape1: s(3, 7), shape2: s(2, 5));
        self::assertIntersectsFalse(shape1: s(10, 11), shape2: s(2, 5));

        self::assertIntersectsTrue(shape1: s(2, 2), shape2: s(2, 2));
        self::assertIntersectsFalse(shape1: s(2, 2), shape2: s(3, 7));
    }

    public function testIntersectsSegmentAndVector(): void
    {
        self::assertIntersectsFalse(shape1: s(1, 2), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(1, 3), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(1, 4), shape2: vp(3));

        self::assertIntersectsFalse(shape1: s(2, 1), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(3, 1), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(4, 1), shape2: vp(3));

        self::assertIntersectsTrue(shape1: s(7, 2), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(7, 3), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(7, 4), shape2: vp(3));

        self::assertIntersectsTrue(shape1: s(2, 7), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(3, 7), shape2: vp(3));
        self::assertIntersectsTrue(shape1: s(4, 7), shape2: vp(3));


        self::assertIntersectsTrue(shape1: s(1, 2), shape2: vn(3));
        self::assertIntersectsTrue(shape1: s(1, 3), shape2: vn(3));
        self::assertIntersectsTrue(shape1: s(1, 4), shape2: vn(3));

        self::assertIntersectsTrue(shape1: s(2, 1), shape2: vn(3));
        self::assertIntersectsTrue(shape1: s(3, 1), shape2: vn(3));
        self::assertIntersectsTrue(shape1: s(4, 1), shape2: vn(3));

        self::assertIntersectsTrue(shape1: s(7, 2), shape2: vn(3));
        self::assertIntersectsTrue(shape1: s(7, 3), shape2: vn(3));
        self::assertIntersectsFalse(shape1: s(7, 4), shape2: vn(3));

        self::assertIntersectsTrue(shape1: s(2, 7), shape2: vn(3));
        self::assertIntersectsTrue(shape1: s(3, 7), shape2: vn(3));
        self::assertIntersectsFalse(shape1: s(4, 7), shape2: vn(3));
    }

    public function testIntersectsVectors(): void
    {
        self::assertIntersectsTrue(shape1: vn(3), shape2: vp(3));
        self::assertIntersectsTrue(shape1: vp(3), shape2: vn(3));
        self::assertIntersectsTrue(shape1: vp(-3), shape2: vn(-3));
        self::assertIntersectsTrue(shape1: vp(3), shape2: vp(-3));
        self::assertIntersectsTrue(shape1: vn(3), shape2: vn(-3));
        self::assertIntersectsFalse(shape1: vn(-3), shape2: vp(3));
        self::assertIntersectsFalse(shape1: vp(3), shape2: vn(-3));
    }

    public function testAllParamsCombinations(): void
    {
        self::assertIntersectsTrue(shape1: p(0), shape2: p(0));
        self::assertIntersectsTrue(shape1: p(0), shape2: s(0, 1));
        self::assertIntersectsTrue(shape1: p(0), shape2: vn(0));
        self::assertIntersectsTrue(shape1: p(0), shape2: vp(0));

        self::assertIntersectsTrue(shape1: s(0, 1), shape2: p(0));
        self::assertIntersectsTrue(shape1: s(0, 1), shape2: s(0, 1));
        self::assertIntersectsTrue(shape1: s(0, 1), shape2: vn(0));
        self::assertIntersectsTrue(shape1: s(0, 1), shape2: vp(0));

        self::assertIntersectsTrue(shape1: vn(0), shape2: p(0));
        self::assertIntersectsTrue(shape1: vn(0), shape2: s(0, 1));
        self::assertIntersectsTrue(shape1: vn(0), shape2: vn(0));
        self::assertIntersectsTrue(shape1: vn(0), shape2: vp(0));

        self::assertIntersectsTrue(shape1: vp(0), shape2: p(0));
        self::assertIntersectsTrue(shape1: vp(0), shape2: s(0, 1));
        self::assertIntersectsTrue(shape1: vp(0), shape2: vn(0));
        self::assertIntersectsTrue(shape1: vp(0), shape2: vp(0));

        self::assertIntersectsFalse(shape1: p(0), shape2: p(1));
        self::assertIntersectsFalse(shape1: p(0), shape2: s(1, 2));
        self::assertIntersectsFalse(shape1: p(0), shape2: vn(-10));
        self::assertIntersectsFalse(shape1: p(0), shape2: vp(10));

        self::assertIntersectsFalse(shape1: s(0,2), shape2: p(5));
        self::assertIntersectsFalse(shape1: s(0,2), shape2: s(5, 7));
        self::assertIntersectsFalse(shape1: s(0,2), shape2: vn(-10));
        self::assertIntersectsFalse(shape1: s(0,2), shape2: vp(10));

        self::assertIntersectsFalse(shape1: vn(0), shape2: p(5));
        self::assertIntersectsFalse(shape1: vn(0), shape2: s(5, 7));
        self::assertIntersectsFalse(shape1: vn(0), shape2: vp(10));

        self::assertIntersectsFalse(shape1: vp(0), shape2: p(-5));
        self::assertIntersectsFalse(shape1: vp(0), shape2: s(-5, -7));
        self::assertIntersectsFalse(shape1: vp(0), shape2: vn(-10));
    }
}
