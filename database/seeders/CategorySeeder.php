<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // اطمینان حاصل کنید که مسیر درست باشد

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ایجاد دسته‌بندی‌های اولیه
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Books']);
        Category::create(['name' => 'Clothing']);
        // اضافه کردن سایر دسته‌بندی‌ها
    }
}
