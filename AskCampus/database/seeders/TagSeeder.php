<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => 'PHP', 'slug' => 'php', 'description' => 'Questions sur PHP'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Questions sur Laravel'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Questions sur JavaScript'],
            ['name' => 'React', 'slug' => 'react', 'description' => 'Questions sur React'],
            ['name' => 'SQL', 'slug' => 'sql', 'description' => 'Questions sur SQL'],
            ['name' => 'Git', 'slug' => 'git', 'description' => 'Questions sur Git'],
            ['name' => 'CSS', 'slug' => 'css', 'description' => 'Questions sur CSS'],
            ['name' => 'HTML', 'slug' => 'html', 'description' => 'Questions sur HTML'],
        ];
        
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}