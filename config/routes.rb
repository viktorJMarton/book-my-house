Rails.application.routes.draw do
  # For details on the DSL available within this file, see https://guides.rubyonrails.org/routing.html
  root to: 'bookings#index'

  namespace :api do
    resource :query, only: [:create]
  end

  resources :bookings, only: [:index, :new, :create]
  resource :query, only: [:new, :create]
  resource :statistic, only: [:show]
  resources :houses, only: [:show, :index]
end
