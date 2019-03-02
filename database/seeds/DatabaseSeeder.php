<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\QrCodeType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $qrCodeTypeTablename = with(new QrCodeType())->getTable();
        $timestamp = date("Y-m-d H:i:s");

        DB::table($qrCodeTypeTablename)->insert([
            [
                "name" => QrCodeType::USER,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                "name" => QrCodeType::MERCHANT,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        ]);
    }
}
