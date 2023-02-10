# frozen_string_literal: true

class HousesController < ApplicationController
  def index
    @house = House.all.ordered
  end

  def show
    @house = House.find(params[:id])

    @bookings_list = if params[:order] == 'desc'
        @house.bookings.order(:day).reverse
      else
        @house.bookings.order(:day)
      end
  end
end
