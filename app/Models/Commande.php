<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero_commande',
        'total',
        'statut',
        'mode_paiement',
        'statut_paiement',
        'adresse_livraison',
        'telephone',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produits')
                    ->withPivot('quantite', 'prix_unitaire', 'prix_total')
                    ->withTimestamps();
    }

    public static function genererNumeroCommande()
    {
        return 'CMD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }
}
