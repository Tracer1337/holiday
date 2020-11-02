<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Filter;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

/**
 * SortByDateFilter sorts the list by date.
 */
final class SortByDateFilter implements HolidayFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): void
    {
        $sorted = $holidayList->getList();
        \usort($sorted, static function (Holiday $o1, Holiday $o2) {
            return $o1->getSimpleDate() <=> $o2->getSimpleDate();
        });
        foreach ($sorted as $index => $holiday) {
            $holidayList->replaceByIndex($index, $holiday);
        }
    }
}
