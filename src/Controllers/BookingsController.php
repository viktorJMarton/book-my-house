<?php

namespace BookMyHouse\Controllers;

use BookMyHouse\Models\Booking;
use BookMyHouse\Models\House;

class BookingsController extends BaseController
{
    public function index(): void
    {
        $bookings = Booking::ordered();
        $this->render('bookings/index', ['bookings' => $bookings]);
    }

    public function new(): void
    {
        $booking = new Booking();
        $houses = House::ordered();
        $this->render('bookings/new', ['booking' => $booking, 'houses' => $houses]);
    }

    public function create(): void
    {
        $bookingData = [
            'day' => $this->getParam('day'),
            'house_id' => (int)$this->getParam('house_id'),
            'number_of_guests' => $this->getParam('number_of_guests') ? (int)$this->getParam('number_of_guests') : null
        ];

        $booking = new Booking($bookingData);
        $errors = $booking->validate();

        if (empty($errors) && $booking->save()) {
            $this->redirect('/');
        } else {
            $houses = House::ordered();
            $this->render('bookings/new', [
                'booking' => $booking, 
                'houses' => $houses, 
                'errors' => $errors
            ]);
        }
    }
}