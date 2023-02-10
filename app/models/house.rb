class House < ApplicationRecord
  has_many :bookings

  validates :name, presence: true, uniqueness: true

  scope :ordered, -> { order(:name, :city) }
end
