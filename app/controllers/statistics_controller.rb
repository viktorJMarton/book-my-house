class StatisticsController < ApplicationController
  def show
    @most_popular_house = House.left_joins(:bookings).group(:id).order('count(bookings.id) DESC').first

    @most_successful_year = Booking.group("strftime('%Y', day)").order('count(day) DESC').limit(1).count.keys.first
  end
end
