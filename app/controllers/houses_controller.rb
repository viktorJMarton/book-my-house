class HousesController < ApplicationController

  def index
    @house = House.all.ordered
  end


  def show 
    @house = House.find(params[:id])
    @bookings_list= @house.bookings.sort_by(&:day) if params[:order]=="asc"
    @bookings_list= @house.bookings.sort_by(&:day).reverse if params[:order]=="desc"
    

  end

end
