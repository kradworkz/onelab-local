<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'email' => 'admin@onelab.com',
            'password' => bcrypt('123456'),
            'type' => 'Administrator',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);

        \DB::table('user_profiles')->insert([
            'firstname' => 'Ra-ouf',
            'lastname' => 'Jumli',
            'gender' => 'Male',
            'birthday' => '2000-01-01',
            'avatar' => 'avatar.jpg',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->call(LocationRegionsTableSeeder::class);
        $this->call(LocationProvincesTableSeeder::class);
        $this->call(LocationMunicipalitiesTableSeeder::class);
        $this->call(DropdownListsTableSeeder::class);

        \DB::table('customers')->insert([
            'name' => 'Referral',
            'status' => 'Active',
            'type_id' => 97,
            'bussiness_id' => 97,
            'industry_id' => 97,
            'classification_id' => 97,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('addresses')->insert([
            'address' => 'Referral',
            'type' => 'Customer',
            'region_id' => 1,
            'municipality_id' => 1,
            'province_id' => 1,
            'addressable_id' => 1,
            'addressable_type' => 'App\Models\Customer',
            'created_at' => now(),
            'updated_at' => now(),
        ]); 

        \DB::table('contacts')->insert([
            'mobile_no' => '00000000000',
            'contactable_id' => 1,
            'contactable_type' => 'App\Models\Address',
            'created_at' => now(),
            'updated_at' => now(),
        ]); 

    }
}
