<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests;

use AP\Geometry\Int1D\Exception\NoIntersectsException;
use AP\Geometry\Int1D\Geometry\Sort;
use AP\Geometry\Int1D\Helpers\Shape;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use Closure;
use Exception;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    final protected static function assertExceptionNoIntersects(Closure $function): void
    {
        self::assertException(NoIntersectsException::class, $function);
    }

    final protected static function assertException(string $expectedExceptionClass, Closure $function): void
    {
        try {
            $function();
            self::fail('Expected exception ' . $expectedExceptionClass . ' not thrown');
        } catch (Exception $e) {
            self::assertInstanceOf(
                expected: $expectedExceptionClass,
                actual: $e
            );
        }
    }

    final protected static function assertShapesCollection(
        ShapesCollection|array|AbstractShape $expected,
        ShapesCollection                     $actual,
        string                               $message = ''
    ): void
    {
        if ($expected instanceof AbstractShape) {
            $expected = [$expected];
        }
        AbstractTestCase::assertEquals(
            expected: Sort::sortByMinAndLength(new ShapesCollection($expected)),
            actual: Sort::sortByMinAndLength($actual),
            message: $message,
        );
    }
}
