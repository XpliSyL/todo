<?php

namespace Database\Seeders;

use App\Models\ProjectStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Niveau 1
        $organisation = ProjectStructure::create(['name' => 'Organisation du projet', 'order' => 1]);
        ProjectStructure::create(['name' => 'Conseil des Expert.e.s', 'order' => 2]);
        $serment = ProjectStructure::create(['name' => 'Serment de Genève', 'order' => 3]);
        ProjectStructure::create(['name' => 'Soirée de gala', 'order' => 4]);
        ProjectStructure::create(['name' => 'Campagnes', 'order' => 5]);
        ProjectStructure::create(['name' => 'Communication', 'order' => 6]);
        ProjectStructure::create(['name' => 'Partenariats', 'order' => 7]);
        ProjectStructure::create(['name' => 'Financement', 'order' => 8]);

        // Niveau 2 sous Serment de Genève
        $rédigerSerment = ProjectStructure::create(['name' => 'Rédiger le Serment', 'parent_id' => $serment->id, 'order' => 1]);
        $trouverSignataires = ProjectStructure::create(['name' => 'Trouver les signataires', 'parent_id' => $serment->id, 'order' => 2]);
        $organiserSoirée = ProjectStructure::create(['name' => 'Organiser la soirée', 'parent_id' => $serment->id, 'order' => 3]);
        ProjectStructure::create(['name' => 'Campagne publique', 'parent_id' => $serment->id, 'order' => 4]);

        // Niveau 3 sous Organiser la soirée
        $l = ProjectStructure::create(['name' => 'Ville de Genève', 'parent_id' => $organiserSoirée->id, 'order' => 1]);
        ProjectStructure::create(['name' => 'Scientifiques', 'parent_id' => $organiserSoirée->id, 'order' => 2]);
        ProjectStructure::create(['name' => 'Agences Onusiennes', 'parent_id' => $organiserSoirée->id, 'order' => 3]);

        $t = new \App\Models\Task();
        $t->project_structure_id = $l->id;
        $t->user_id = 1;
        $t->task_types_id = 1;
        $t->contact_id = 1;
        $t->name = 'Contacter Alfonso Gomez';
        $t->details = "Prendre rdv avec Sandrine (sa secrétaire)\nRegarder comment ils entrent en matière (5 lignes)\n1\n2\n3\n4\n5";
        $t->status = 'todo';
        $t->due_date = '2024.10.5';
        $t->save();

        $d = new \App\Models\Document();
        $d->name = 'ProDoc Serment de Genève';
        $d->link = 'https://docs.google.com/document/u/0/d/1hJ0gJZ81RVj5jIIncr1i5T7p51_Rkw4olpdsgXk7bYI/mobilebasic?invite=CPbd8-oH&pli=1#';
        $d->task_id = $t->id;
        $d->save();
    }
}
