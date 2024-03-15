<?php declare(strict_types=1);

namespace AP\Geometry\Int1D\Tests\Sort;

use AP\Geometry\Int1D\Sort\Sort;
use AP\Geometry\Int1D\Sort\SortElement;
use AP\Geometry\Int1D\Sort\SortElementsCollection;
use AP\Geometry\Int1D\Tests\AbstractTestCase;
use Exception;

final class SortTest extends AbstractTestCase
{
    public function testSimple(): void
    {
        $this->assertEquals(
            ["first", "second", "third"],
            Sort::sort(new SortElementsCollection([
                (new SortElement("third"))->addSortValue(3.14),
                (new SortElement("second"))->addSortValue(2.73),
                (new SortElement("first"))->addSortValue(1.21),
            ]))
        );

        $fiveElement = new Exception("test");
        $this->assertEquals(
            [
                "first",
                "second",
                "third",
                $fiveElement,
            ],
            Sort::sort(new SortElementsCollection([
                (new SortElement($fiveElement))->addSortValue(5),
                (new SortElement("first"))->addSortValue(1),
                (new SortElement("second"))->addSortValue(2),
                (new SortElement("third"))->addSortValue(3),
            ]))
        );

        $this->assertEquals(
            [
                "minus_infinity",
                "minus_one",
                "zero",
                "five",
                "plus_infinity",
            ],
            Sort::sort(new SortElementsCollection([
                (new SortElement("plus_infinity"))->addSortValue(INF),
                (new SortElement("five"))->addSortValue(5),
                (new SortElement("zero"))->addSortValue(0),
                (new SortElement("minus_one"))->addSortValue(-1),
                (new SortElement("minus_infinity"))->addSortValue(-INF),
            ]))
        );
    }

    public function testMulti(): void
    {
        $this->assertEquals(
            [
                "c___1_5",
                "e___1_10",
                "b___2",
                "a___3_m7",
                "d___3_11",
            ],
            Sort::sort(new SortElementsCollection([
                (new SortElement("a___3_m7"))->addSortValue(3)->addSortValue(-7),
                (new SortElement("b___2"))->addSortValue(2),
                (new SortElement("c___1_5"))->addSortValue(1)->addSortValue(5),
                (new SortElement("d___3_11"))->addSortValue(3)->addSortValue(11),
                (new SortElement("e___1_10"))->addSortValue(1)->addSortValue(10),
            ]))
        );
    }

    public function testSortForSame(): void
    {
        $this->assertEquals(
            [
                "1",
                "2_first",
                "2_second",
                "3",
            ],
            Sort::sort(new SortElementsCollection([
                (new SortElement("3"))->addSortValue(3),
                (new SortElement("2_first"))->addSortValue(2),
                (new SortElement("2_second"))->addSortValue(2),
                (new SortElement("1"))->addSortValue(1),
            ]))
        );

        $this->assertEquals(
            [
                "-1",
                "1",
                "2_first",
                "2_second_with_extra_param",
                "2_third",
                "3",
                "11",
            ],
            Sort::sort(new SortElementsCollection([

                (new SortElement("11"))->addSortValue(11),
                (new SortElement("2_first"))->addSortValue(2),
                (new SortElement("2_second_with_extra_param"))->addSortValue(2)->addSortValue(5),
                (new SortElement("-1"))->addSortValue(-1),
                (new SortElement("3"))->addSortValue(3),
                (new SortElement("2_third"))->addSortValue(2),
                (new SortElement("1"))->addSortValue(1),
            ]))
        );
    }
}
