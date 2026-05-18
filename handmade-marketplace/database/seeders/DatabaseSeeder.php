<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    User::updateOrCreate(
      ['email' => 'admin@craftnest.test'],
      [
        'name' => 'CraftNest Admin',
        'password' => Hash::make('password'),
        'role' => 'admin',
      ]
    );

    User::updateOrCreate(
      ['email' => 'seller@craftnest.test'],
      [
        'name' => 'Demo Seller',
        'password' => Hash::make('password'),
        'role' => 'seller',
      ]
    );

    User::updateOrCreate(
      ['email' => 'buyer@craftnest.test'],
      [
        'name' => 'Demo Buyer',
        'password' => Hash::make('password'),
        'role' => 'buyer',
      ]
    );
  }
}
