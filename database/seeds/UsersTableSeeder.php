<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Snippet;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->delete_seeded_users();
      $this->seed_users();
    }

    private function seed_users()
    {
      $lincoln = User::create([
        'name'=>'Abraham Lincoln',
        'email'=>'lincoln@lincoln.com',
        'password'=> bcrypt('lincoln'),
      ]);
      $washington = User::create([
        'name'=>'George Washington',
        'email'=>'washington@washington.com',
        'password'=> bcrypt('washington'),
      ]);
      $roosevelt = User::create([
        'name'=>'Theodore Roosevelt',
        'email'=>'roosevelt@roosevelt.com',
        'password'=> bcrypt('roosevelt'),
      ]);
      $kennedy = User::create([
        'name'=>'Jack Kennedy',
        'email'=>'kennedy@kennedy.com',
        'password'=> bcrypt('kennedy'),
      ]);

      $this->seed_snippets_in_user($lincoln);
      $this->seed_snippets_in_user($washington);
      $this->seed_snippets_in_user($roosevelt);
      $this->seed_snippets_in_user($kennedy);
    }
    

    private function seed_snippets_in_user($user)
    {
      factory(Snippet::class, 60)->make()->each(function($snippet) use($user) {
        $user->snippets()->create($snippet->toArray());
      });
    }
    
    private function delete_seeded_users()
    {
      try {
        User::where('email', 'lincoln@lincoln.com')->firstOrFail()->delete();
        User::where('email', 'washington@washington.com')->firstOrFail()->delete();
        User::where('email', 'roosevelt@roosevelt.com')->firstOrFail()->delete();
        User::where('email', 'kennedy@kennedy.com')->firstOrFail()->delete();
      } catch (Exception $e) {
        echo 'No users to delete';
      }
    }
    
}
