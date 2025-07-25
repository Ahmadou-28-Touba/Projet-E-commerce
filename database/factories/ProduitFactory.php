<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ProduitFactory extends Factory
{
    protected $model = \App\Models\Produit::class;

    public function definition()
    {
        // Récupérer le chemin des images disponibles dans public/images/produits
        $images = File::files(public_path('images/produits'));

        // Choisir une image aléatoire (nom du fichier seulement)
        $randomImage = collect($images)->random()->getFilename();

        return [
            'nom' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'prix' => $this->faker->randomFloat(2, 10, 500),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => $randomImage, // nom d'une vraie image existante
            'categorie_id' => \App\Models\Categorie::factory(),
        ];
    }
}
