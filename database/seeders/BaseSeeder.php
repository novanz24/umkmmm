<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class BaseSeeder extends Seeder
{
    public function run(): void
    {
        // akun contoh
        User::firstOrCreate(['email'=>'admin@example.com'], [
            'name'=>'Admin','password'=>bcrypt('password'),'role'=>'admin'
        ]);
        User::firstOrCreate(['email'=>'user@example.com'], [
            'name'=>'User','password'=>bcrypt('password'),'role'=>'user'
        ]);

        // kategori
        $catIds = collect(['Fashion','Makanan','Kerajinan'])
            ->mapWithKeys(fn($n) => [ $n => Category::firstOrCreate(['name'=>$n])->id ]);

        // produk (is_active = 1)
        Product::firstOrCreate(['name'=>'Kaos Basic Hitam'], [
            'category_id'=>$catIds['Fashion'],'stock'=>50,'price'=>65000,'is_active'=>true
        ]);
        Product::firstOrCreate(['name'=>'Keripik Singkong 200g'], [
            'category_id'=>$catIds['Makanan'],'stock'=>80,'price'=>18000,'is_active'=>true
        ]);
        Product::firstOrCreate(['name'=>'Tas Anyam'], [
            'category_id'=>$catIds['Kerajinan'],'stock'=>20,'price'=>120000,'is_active'=>true
        ]);
    }
}
