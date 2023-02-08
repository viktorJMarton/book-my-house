class BookingsController < ApplicationController
  def index
    @bookings = Booking.all.ordered
    per_page = params[:per_page] ? params[:per_page].to_i : 4
    
    @bookings = Booking.paginate(page: params[:page], per_page:4)
    @bookings = Booking.paginate(page: params[:page], per_page: per_page)
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
