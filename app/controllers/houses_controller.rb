class HousesController < ApplicationController

  def index
    @house = House.all.ordered
  end


  def show 
    @house = House.find(params[:id])
    

  end

end
