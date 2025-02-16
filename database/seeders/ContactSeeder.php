<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('contacts')->insert([
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone' => '+977-9876543210',
                'subject' => 'Inquiry about Property',
                'message' => 'I am interested in renting a property. Please provide more details.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'phone' => '+977-9801122334',
                'subject' => 'Payment Inquiry',
                'message' => 'Can I pay my rent using online banking? Please confirm.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michaelj@example.com',
                'phone' => '+977-9812345678',
                'subject' => 'Request for Visit',
                'message' => 'I would like to schedule a visit for the listed apartment.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Emily Brown',
                'email' => 'emilybrown@example.com',
                'phone' => '+977-9823456789',
                'subject' => 'Maintenance Request',
                'message' => 'There is a water leakage issue in the apartment. Please fix it as soon as possible.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
