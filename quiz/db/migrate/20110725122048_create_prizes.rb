class CreatePrizes < ActiveRecord::Migration
  def self.up
    create_table :prizes do |t|
      t.integer :game_id
      t.integer :level
      t.integer :amount
      t.timestamps
    end
  end

  def self.down
    drop_table :prizes
  end
end
