<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests;

use AP\Geometry\Int1D\Geometry\Sort;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    final protected static function assertShapesCollection(
        ShapesCollection|array $expected,
        ShapesCollection       $actual,
        string                 $message = ''
    ): void
    {
        AbstractTestCase::assertEquals(
            expected: Sort::sortByMinAndLength(new ShapesCollection($expected)),
            actual: Sort::sortByMinAndLength($actual),
            message: $message,
        );
    }
}
