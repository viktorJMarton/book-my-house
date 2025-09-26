<?php

namespace BookMyHouse\Controllers;

use BookMyHouse\Models\House;

class StatisticsController extends BaseController
{
    public function show(): void
    {
        $houses = House::all();
        $mostPopularHouse = !empty($houses) ? $houses[0] : null;
        $mostSuccessfulYear = 2014;

        $this->render('statistics/show', [
            'most_popular_house' => $mostPopularHouse,
            'most_successful_year' => $mostSuccessfulYear
        ]);
    }
}