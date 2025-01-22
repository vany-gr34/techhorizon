<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interest; // Import the Interest model

class InterestsSeeder extends Seeder
{
    public function run()
    {
        // Define the list of interests to insert
        $interests = [
            'Intelligence Artificielle',
            'Cybersécurité',
            'Big Data',
            'Cloud Computing',
            'Blockchain',
            'Robotics',
            'Data Science',
            'Développement Web',
            'Développement Mobile',
            'Machine Learning',
            'Internet des Objets',
            'Réality Virtuelle',
            'Design UX/UI',
            'SEO',
            'Marketing Digital',
            'Automatisation',
            'Réseaux et Infrastructure',
            'Base de données',
            'Systèmes embarqués',
            'Programmation Python',
            'Programmation JavaScript',
            'DevOps',
            'Performance Systèmes',
            'Technologies Web 3.0',
            'Applications Cloud',
        ];

        // Insert the interests into the interests table
        foreach ($interests as $interest) {
            Interest::create(['name' => $interest]);
        }
    }
}
