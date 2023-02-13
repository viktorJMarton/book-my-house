class BookingsController < ApplicationController
  def index
    @bookings = Booking.all.ordered
  end

  def new
    @booking = Booking.new
  end

  def create
    @booking = Booking.new(booking_params)

    if @booking.save
      redirect_to bookings_path
    else
      render :new
    end
  end

  private

  def booking_params
    params.require(:booking).permit(:day, :house_id,:number_of_guests)
  end
end
