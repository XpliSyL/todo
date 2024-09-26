<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = new \App\Models\User();
        $user->name = 'Admin';
        $user->email = 'admin@dynamic.com';
        $user->password = bcrypt('admin');
        $user->is_admin = true;
        $user->save();

        $entity1 = new \App\Models\Entity();
        $entity1->name = 'Ville de Genève';
        $entity1->save();

        $entity = new \App\Models\Entity();
        $entity->name = 'Ville de Lausanne';
        $entity->save();

        $tag = new \App\Models\Tag();
        $tag->name = 'Financeurs';
        $tag->save();

        $tag = new \App\Models\Tag();
        $tag->name = 'Mécène';
        $tag->save();

        $tag = new \App\Models\Tag();
        $tag->name = 'Contact de Pierre';
        $tag->save();

        $tag = new \App\Models\TaskType();
        $tag->type = 'Tâche';
        $tag->save();
        $tag = new \App\Models\TaskType();
        $tag->type = 'Téléphone';
        $tag->save();
        $tag = new \App\Models\TaskType();
        $tag->type = 'Courriel';
        $tag->save();
        $tag = new \App\Models\TaskType();
        $tag->type = 'Séance';
        $tag->save();
        $tag = new \App\Models\TaskType();
        $tag->type = 'Document';
        $tag->save();

        $d = new \App\Models\Document();
        $d->name = 'ProDoc Serment de Genève';
        $d->link = 'https://docs.google.com/document/u/0/d/1hJ0gJZ81RVj5jIIncr1i5T7p51_Rkw4olpdsgXk7bYI/mobilebasic?invite=CPbd8-oH&pli=1#';
        $d->save();

        $c = new \App\Models\Contact();
        $c->first_name = 'Alfonso';
        $c->last_name = 'Gomez';
        $c->job_title = 'Conseiller municipal Genève';
        $c->phone = '+41 79 400 54 54';
        $c->email = 'alfonso@gomez.ge';
        $c->entity_id = $entity1->id;
        $c->save();

        $this->call([
            ProjectStructureSeeder::class,
        ]);
    }
}
