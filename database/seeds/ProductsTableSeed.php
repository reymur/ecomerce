<?php

use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        for ($i = 1; $i < 30; $i++){
            Product::create([
                'name' => 'Laptop'. $i,
                'slug' => 'laptop-'.$i,
                'details' => [13,14,15][array_rand([13,14,15])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(149999,249999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(1);
        }

        $product = Product::find(1);
        $product->categories()->attach(2);

        for ($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'Desktop'. $i,
                'slug' => 'desktop-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(249999,449999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(2);
        }

        for ($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'Mobile Phone'. $i,
                'slug' => 'Mobile-Phone-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(249999,449999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(3);
        }

        for ($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'Tablet'. $i,
                'slug' => 'Tablet-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(249999,449999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(4);
        }

        for ($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'TV'. $i,
                'slug' => 'TV-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(249999,449999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(5);
        }

        for ($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'Digital Camera'. $i,
                'slug' => 'Digital Camera-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(249999,449999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(6);
        }

        for ($i = 1; $i < 9; $i++){
            Product::create([
                'name' => 'Appliance'. $i,
                'slug' => 'Appliance-'.$i,
                'details' => [24,25,27][array_rand([24,25,27])].'inch, '.[1,2,3][array_rand([1,2,3])].'TB SSD, 32GB RAM',
                'price' => random_int(249999,449999),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?'
            ])->categories()->attach(7);
        }

    }
}
