<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Shape;

use AP\Structure\Collection\AbstractCollection;
use AP\Structure\Collection\ObjectsCollection;

class ShapesCollection extends ObjectsCollection
{
    public function __construct(
        array|AbstractCollection $data = []
    )
    {
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