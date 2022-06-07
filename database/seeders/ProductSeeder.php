<?php

namespace Database\Seeders;

use App\Models\Product;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = array("ikea", "jysk","tesco","dove","kleenex","rauch","gorenje","phillips","novaco","lipton","acer");
        $categories = array("householdgoods", "craft","toiletries");
        $images = array("hg", "const","t");

        for($k = 0; $k < 3; $k++){
            for($i = 1; $i < 23 ; $i++){

                $files = [];
                for($j = 0; $j< 2; $j++){
                    array_push($files, "$images[$k]"."$i"."_"."$j".".jpg");
                }
                if($i % 2 ==  0){
                    $title = "$categories[$k]"."$i"."_DC";
                    $discount = true;
                }
                else{
                    $title = "$categories[$k]"."$i";
                    $discount = false;
                }

                $product = ['productTitle' => $title,
                'productImage' => json_encode($files), 
                'productType' => $categories[$k],
                'productBrand' => $brands[rand(0, 10)],
                'productAmount' => rand(100,1000),
                'productdetail' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ",
                'productDiscount' =>  $discount,
                'productPrice' => rand(1,150),
                'created_at' => date("Y-m-d H:i:s")];
                Product::insert($product);
            }
        }
    }
}