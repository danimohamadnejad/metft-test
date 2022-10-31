<?php
namespace Metft\Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Metft\FeedReader\Models\NewsServer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NewsServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = NewsServer::class;
    
    public function definition()
    {
        return [
            "home_url"=>"",
            "feeds_url"=>"",
            "name"=>"",
        ];
    }

    public function create_servers_from_config(){
     $config = config("feedReader");
     $servers = $config['feed-servers'];
     foreach($servers as $key=>$server_array){
        $this->create($server_array);
     }
    }
}
