<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Sort;

use AP\Structure\Collection\AbstractCollection;
use AP\Structure\Collection\ObjectsCollection;

class SortElementsCollection extends ObjectsCollection
{
    public function __construct(
        array|AbstractCollection $data = []
    )
    {
        parent::__construct(
            class: SortElement::class,
            data: $data
        );
    }

    /**
     * @return SortElement[]
     */
    public function all(): array
    {
        return parent::all();
    }
}