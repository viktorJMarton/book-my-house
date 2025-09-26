<?php

namespace BookMyHouse\Controllers\Api;

use BookMyHouse\Controllers\BaseController;
use BookMyHouse\Models\Booking;
use DateTime;

class QueriesController extends BaseController
{
    public function create(): void
    {
        $date = $this->parseApiDate();
        
        if ($date) {
            $booked = Booking::bookedFor($date);
            $this->jsonResponse(['booked' => $booked]);
        } else {
            http_response_code(400);
            $this->jsonResponse(['error' => 'Invalid date format']);
        }
    }

    private function parseApiDate(): ?string
    {
        $booking = $this->getParam('booking');
        
        if (!$booking || !is_array($booking)) {
            return null;
        }

        $year = $booking['year'] ?? null;
        $month = $booking['month'] ?? null;
        $day = $booking['day'] ?? null;

        if ($year && $month && $day) {
            try {
                $date = new DateTime("{$year}-{$month}-{$day}");
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}