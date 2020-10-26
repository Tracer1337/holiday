<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Filter;

use umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Test\HolidayTestCase;

final class IncludeUniqueDateFilterTest extends HolidayTestCase
{
    /**
     * @var IncludeUniqueDateFilter
     */
    private $filter;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getData
     *
     * @param string[] $holidays
     */
    public function it_should_filter_holidays(array $holidays, array $expectedResult): void
    {
        $this->givenAnIncludeUniqueDateFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeUniqueDateFilter(): void
    {
        $this->filter = new IncludeUniqueDateFilter();
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $date) {
            $holidayList->add(Holiday::create('name', $date));
        }
        $this->actualResult = $holidayList->filter($this->filter);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned($expectedResult): void
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getFormattedDate('Y-m-d');
        }
        self::assertEquals($expectedResult, $resultDates);
    }

    public function getData(): array
    {
        return [
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                ],
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-03',
                ],
                [
                    '2016-01-01',
                    '2016-01-03',
                ],
            ],
            [
                [],
                [],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-03',
                    '2016-01-13',
                    '2016-01-13',
                ],
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-13',
                ],
            ],
        ];
    }
}
