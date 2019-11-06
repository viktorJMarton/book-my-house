require 'test_helper'

class BookingTest < ActionDispatch::IntegrationTest
  test 'can see the index page' do
    get '/'

    assert_select 'h1', 'Book-My-House'
  end

  test 'can access the booking creation page' do
    get '/bookings/new'

    assert_response :success
    assert_select 'h1', 'Book the house!'
  end

  test 'can create a valid booking' do
    date = Date.today
    post '/bookings', params: { booking: { 'day(1i)' => date.year, 'day(2i)' => date.month, 'day(3i)' => date.day } }
    follow_redirect!

    assert_response :success
    assert_select '.booking', date.to_s
  end

  test 'cannot create an invalid booking' do
    date = Date.today
    Booking.create!(day: date)
    post '/bookings', params: { booking: { 'day(1i)' => date.year, 'day(2i)' => date.month, 'day(3i)' => date.day } }

    assert_response :success
    assert_select '.error', 'Day has already been taken'
  end

  test 'can query a day for booking info' do
    date = Date.today
    booking_params = { booking: { 'day(1i)' => date.year, 'day(2i)' => date.month, 'day(3i)' => date.day } }

    post '/query', params: booking_params
    assert_response :success
    assert_select '#booked-result', 'Yay! You can book the house on the selected day!'

    Booking.create!(day: date)
    post '/query', params: booking_params

    assert_response :success
    assert_select '#booked-result', 'The house is booked for the selected day :('
  end
end
