class HousesController < ApplicationController

  def index
    @house = House.all.ordered
  end


  def show 
    @house = House.find(params[:id])
    
    @bookings_list = if params[:order]=="desc"
      @house.bookings.sort_by(&:day).reverse
    else
      @house.bookings.sort_by(&:day)
    end
  end

end
