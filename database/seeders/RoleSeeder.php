<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
      $roles_array = config('app.roles-information.roles-data');
      foreach($roles_array as $role_data){
       Role::create($role_data); 
      }
    }
}
