<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=100;$i++)
        Post::create([
            'title'=>"Lorem ipsum dolor",
            'body'=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur eum officia nostrum asperiores adipisci maiores, sed delectus est numquam laboriosam dolore rem debitis cum obcaecati? Voluptates",
            'slug'=>uniqid(),
            'image'=>'1.jpg',
            'thumbnail'=>'1_thumbnail.jpg',
        ]);
    }
}
