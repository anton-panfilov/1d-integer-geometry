<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Geometry;

use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Shape\AbstractShape;
use AP\Geometry\Int1D\Exception\Infinity;
use AP\Structure\Sort\Sort as SortLib;
use AP\Structure\Sort\SortElementsCollection;
use AP\Structure\Sort\SortElement;
use UnexpectedValueException;

class Sort
{
    /**
     * using pre-get values because some values like ->min() take extra calculation,
     * and otherwise it will be run every sort iteration
     *
     * @param SortElementsCollection $toSort
     * @return ShapesCollection
     * @throws UnexpectedValueException
     */
    protected static function sortAbstract(SortElementsCollection $toSort): ShapesCollection
    {
        $toSortArray = SortLib::sort($toSort);
        $res = new ShapesCollection();
        foreach ($toSortArray as $toSortElement) {
            if($toSortElement instanceof AbstractShape) {
                $res[] = $toSortElement;
            } else {
                throw new UnexpectedValueException(
                    message: 'invalid element type: ' . get_debug_type($toSortElement) . ", expected: AbstractShape"
                );
            }
        }
        return $res;
    }

    public static function sortByMin(ShapesCollection $shapes): ShapesCollection
    {
        $toSort = new SortElementsCollection();
        foreach ($shapes->all() as $shape) {
            $toSortElement = new SortElement(element: $shape);

            try {
                $toSortElement->addSortValue($shape->min()->value);
            } catch (Infinity) {
                // this exception can be from the vectors
                $toSortElement->addSortValue(-INF);
            }

            $toSort[] = $toSortElement;
        }
        return self::sortAbstract($toSort);
    }

    public static function sortByMinAndLength(ShapesCollection $shapes): ShapesCollection
    {
        $toSort = new SortElementsCollection();
        foreach ($shapes->all() as $shape) {
            $toSortElement = new SortElement(element: $shape);

            try {
                $toSortElement->addSortValue($shape->min()->value);
            } catch (Infinity) {
                // this exception can be from the vectors
                $toSortElement->addSortValue(-INF);
            }

            try {
                $toSortElement->addSortValue($shape->max()->value);
            } catch (Infinity) {
                // this exception can be from the vectors
                $toSortElement->addSortValue(INF);
            }

            $toSort[] = $toSortElement;
        }
        return self::sortAbstract($toSort);
    }
}