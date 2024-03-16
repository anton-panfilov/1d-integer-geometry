<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

use AP\Structure\Collection\AbstractCollection;
use AP\Structure\Collection\ObjectsCollection;

class ShapesCollection extends ObjectsCollection
{
    public function __construct(
        array|AbstractShape|AbstractCollection $data = []
    )
    {
        if ($data instanceof AbstractShape) {
            $data = [$data];
        }
        parent::__construct(
            class: AbstractShape::class,
            data: $data
        );
    }

    /**
     * @return AbstractShape[]
     */
    public function all(): array
    {
        return parent::all();
    }
}