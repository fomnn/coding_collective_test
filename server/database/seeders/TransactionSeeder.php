<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            "John Doe", "Jane Smith", "Michael Johnson", "Sarah Williams",
            "Robert Brown", "Emily Davis", "William Wilson", "Emma Taylor",
            "James Anderson", "Olivia Martinez", "David Thomas", "Sophia Garcia",
            "Joseph Miller", "Isabella Robinson", "Daniel White"
        ];

        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $type = rand(0, 1) ? 'deposite' : 'withdraw';
            $data[] = [
                "amount" => rand(100000, 40000000),
                "order_id" => $type == 'deposite'? substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16) : '-',
                "timestamp" => now()->subDays(rand(0, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59))->toISOString(),
                "status" => rand(1,2),
                "type" => $type,
                "user_fullname" => $names[$i],
                "created_at" => now(),
                "updated_at" => now(),
                "gateway_transaction_id" => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16)
            ];
        }

        DB::table("transactions")->insert($data);
    }
}
