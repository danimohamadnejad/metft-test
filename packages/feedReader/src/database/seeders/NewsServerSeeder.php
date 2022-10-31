<?php
namespace Metft\Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Metft\FeedReader\Models\NewsServer;

class NewsServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      NewsServer::factory()->create_servers_from_config();
    }
}
