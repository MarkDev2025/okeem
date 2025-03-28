<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Etablissement;
use App\Models\Enfant;
use App\Models\Tuteur;
use App\Models\Okeemien;
use App\Models\Presence;
use App\Models\Facture;
use App\Models\Transmission;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // if (!\App\Models\User::where('email', 'test@example.com')->exists()) {
        //     \App\Models\User::factory()->create([
        //         'name' => 'user',
        //         'email' => 'test@example.com',
        //     ]);
        // }

        // 🔥 Supprimer tous les utilisateurs avant de recréer des données
        User::truncate();

        // ✅ Créer un utilisateur admin
        User::factory()->admin()->create();

        // ✅ Générer 10 utilisateurs normaux
        User::factory(3)->create();


        $faker = Faker::create('fr_FR');
        Storage::disk('public')->makeDirectory('avatars');
        Storage::disk('public')->makeDirectory('factures');
        Storage::disk('public')->makeDirectory('transmissions');

        // Création des établissements
        $jours_activite = [2, 3, 4];
        $etablissements = [];
        // for ($i = 1; $i <= 3; $i++) {
        //     $etablissements[] = Etablissement::create([
        //         'nom' => 'Établissement ' . $i,
        //         'slug' => Str::slug('Établissement ' . $i, '-'),
        //         'type' => $faker->randomElement(['Micro-crèche']),
        //         'lieu' => $faker->city,
        //         'nom_responsable' => $faker->name,
        //         'nombre_okeemiens' => 2
        //     ]);
        // }
        $etablissements[] = Etablissement::create([
            'nom' => 'Mini-crèche des Alpes',
            'slug' => Str::slug('Mini-crèche des Alpes', '-'),
            'type' => $faker->randomElement(['Micro-crèche']),
            'lieu' => $faker->city,
            'nom_responsable' => $faker->name,
            'nombre_okeemiens' => 2
        ]);
        $etablissements[] = Etablissement::create([
            'nom' => 'Mini-crèche de Bordeaux',
            'slug' => Str::slug('Mini-crèche de Bordeaux', '-'),
            'type' => $faker->randomElement(['Micro-crèche']),
            'lieu' => $faker->city,
            'nom_responsable' => $faker->name,
            'nombre_okeemiens' => 2
        ]);
        $etablissements[] = Etablissement::create([
            'nom' => 'Mini-crèche de Bretagne',
            'slug' => Str::slug('Mini-crèche de Bretagne', '-'),
            'type' => $faker->randomElement(['Micro-crèche']),
            'lieu' => $faker->city,
            'nom_responsable' => $faker->name,
            'nombre_okeemiens' => 2
        ]);

        // Préparation des avatars fixes (chatons)
        $avatars_chatons = [
            'avatars/chaton_1.jpg',
            'avatars/chaton_2.jpg',
            'avatars/chaton_3.jpg',
            'avatars/chaton_4.jpg',
            'avatars/chaton_5.jpg',
            'avatars/chaton_6.jpg',
            'avatars/chaton_7.jpg',
            'avatars/chaton_8.jpg',
            'avatars/chaton_9.jpg',
            'avatars/chaton_10.jpg'
        ];

        // Création des enfants, éducateurs, tuteurs et données associées
        foreach ($etablissements as $index => $etablissement) {
            $nb_enfants = rand(8, 10);
            $okeemiens = Okeemien::factory(2)->create();
            foreach ($okeemiens as $index => $okeemien) {
                $okeemien->etablissements()->attach($etablissement);
            }

            for ($j = 1; $j <= $nb_enfants; $j++) {
                $avatar = $avatars_chatons[$j % count($avatars_chatons)];

                $enfant = Enfant::create([
                    'prenom' => $faker->firstName,
                    'nom' => $faker->lastName,
                    'slug' => Str::slug($faker->firstName . ' ' . $faker->lastName, '-'),
                    'date_naissance' => $faker->dateTimeBetween('-5 years', '-6 months')->format('Y-m-d'),
                    'etablissement_id' => $etablissement->id,
                    'avatar' => $avatar
                ]);

                $tuteurs = Tuteur::factory(rand(1, 2))->create();
                foreach ($tuteurs as $tuteur) {
                    $enfant->tuteurs()->attach($tuteur);
                    $tuteur->etablissements()->attach($etablissement);

                    // Création de factures avec fichier PDF factice
                    $pdf = 'factures/facture_' . $enfant->id . '.pdf';
                    Storage::disk('public')->put($pdf, 'Fichier PDF factice pour la facture de ' . $enfant->prenom);

                    Facture::create([
                        'tuteur_id' => $tuteur->id,
                        'etablissement_id' => $etablissement->id,
                        'montant' => rand(50, 200),
                        'statut' => $faker->randomElement(['payee', 'envoyee', 'en_retard']),
                        'pdf' => $pdf
                    ]);
                }

                // Création de présences cohérentes
                for ($k = 0; $k < $jours_activite[$index]; $k++) {
                    Presence::create([
                        'enfant_id' => $enfant->id,
                        'jour' => now()->subDays($k),
                        'heure_debut' => '08:30:00',
                        'heure_fin' => '16:30:00'
                    ]);
                }

                // Images fixes pour les transmissions
                $transmission_images = [
                    'transmissions/sieste.jpg',
                    'transmissions/premier_mot.jpg',
                    'transmissions/premier_pas.jpg',
                    'transmissions/change_frequent.jpg',
                    'transmissions/interet_jeu.jpg'
                ];
                $message_transmission = [
                    'A fait sa sieste paisiblement.',
                    'A dit son premier mot aujourd’hui !',
                    'A marché sans appui pour la première fois.',
                    'A eu des changes plus fréquents aujourd’hui.',
                    'A montré un grand intérêt pour les jeux de construction.'
                ];

                $randomIndex = array_rand($transmission_images);
                $okeemien = $okeemiens->random()->id;
                Transmission::create([
                    'okeemien_id' => $okeemien,
                    'enfant_id' => $enfant->id,
                    'etablissement_id' => $enfant->etablissement->id,
                    'message' => $message_transmission[$randomIndex],
                    'fichier' => $transmission_images[$randomIndex],
                    'jour' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'), // Date aléatoire entre aujourd'hui et il y a 30 jours
                    'heure_debut' => Carbon::now()->subHours(rand(1, 5))->format('H:i:s'), // Heure début aléatoire
                    'heure_fin' => Carbon::now()->subHours(rand(1, 5))->addMinutes(rand(15, 90))->format('H:i:s'), // Heure fin après début
                ]);
            }
        }
    }
}
