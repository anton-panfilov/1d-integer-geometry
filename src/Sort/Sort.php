<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Sort;

class Sort
{
    public static function sort(SortElementsCollection $toSort): array
    {
        $toSortArray = $toSort->all();
        usort($toSortArray, function (SortElement $a, SortElement $b) {
            $i = 0;
            while (true) {
                if (isset($a->getSortValues()[$i], $b->getSortValues()[$i])) {
                    if ($a->getSortValues()[$i] == $b->getSortValues()[$i]) {
                        $i++;
                        continue;
                    } else {
                        return ($a->getSortValues()[$i] < $b->getSortValues()[$i]) ? -1 : 1;
                    }
                }
                break;
            }
            return 0;
        });
        $res = [];
        foreach ($toSortArray as $toSortElement) {
            $res[] = $toSortElement->element;
        }
        return $res;
    }
}