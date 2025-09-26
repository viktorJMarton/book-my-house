<?php

namespace BookMyHouse\Controllers;

use BookMyHouse\Models\Booking;
use DateTime;

class QueriesController extends BaseController
{
    public function new(): void
    {
        $reactEnabled = isset($_GET['react']);
        $this->render('queries/new', ['react_enabled' => $reactEnabled]);
    }

    public function create(): void
    {
        $day = $this->parseDate();
        $booked = null;
        $errors = [];

        if ($day) {
            $booked = Booking::bookedFor($day);
        } else {
            $errors[] = 'Invalid date provided';
        }

        $reactEnabled = isset($_GET['react']) || isset($_POST['react']);
        $this->render('queries/new', [
            'react_enabled' => $reactEnabled,
            'day' => $day,
            'booked' => $booked,
            'errors' => $errors
        ]);
    }

    private function parseDate(): ?string
    {
        // Handle both date formats: Y-m-d and Rails date_select format
        if ($this->getParam('day')) {
            return $this->getParam('day');
        }

        $year = $this->getParam('year') ?? $this->getParam('day_1i');
        $month = $this->getParam('month') ?? $this->getParam('day_2i');
        $dayValue = $this->getParam('day_value') ?? $this->getParam('day_3i');

        if ($year && $month && $dayValue) {
            try {
                $date = new DateTime("{$year}-{$month}-{$dayValue}");
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}