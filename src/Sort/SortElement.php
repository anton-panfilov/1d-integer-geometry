<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Sort;

class SortElement
{
    /**
     * @var float[]
     */
    protected array $floats = [];

    public function __construct(public $element)
    {
    }

    /**
     * Adds a float value to the existing array of floats.
     * The first float will have more priority that second.
     *
     * @param float $value The float value to be added.
     */
    public function addSortValue(float $value): static
    {
        $this->floats[] = $value;
        return $this;
    }

    /**
     * @return float[]
     */
    public function getSortValues(): array
    {
        return $this->floats;
    }
}