class Booking < ApplicationRecord
  belongs_to :house

  validates :day, presence: true, uniqueness: true
  validates :number_of_guests, presence: true, inclusion: { in: 1..8, message: 'the number of guests should be between 1 and 8.' }

  scope :ordered, -> { order(:day) }

  def self.booked_for?(date)
    where(day: date).present?
  end
end
