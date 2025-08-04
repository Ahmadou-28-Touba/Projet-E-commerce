<?php

namespace App\Console\Commands;

use App\Models\Commande;
use App\Mail\ConfirmationCommande;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--commande=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l\'envoi d\'email de confirmation de commande';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $commandeId = $this->option('commande');

        if ($commandeId) {
            // Test avec une vraie commande
            $commande = Commande::with(['user', 'produits'])->find($commandeId);
            
            if (!$commande) {
                $this->error("Commande #{$commandeId} non trouvée !");
                return 1;
            }

            $this->info("Envoi d'email de confirmation pour la commande #{$commande->numero_commande} à {$email}...");
            
            try {
                Mail::to($email)->send(new ConfirmationCommande($commande));
                $this->info('✅ Email envoyé avec succès !');
                $this->info("📧 Destinataire : {$email}");
                $this->info("📦 Commande : #{$commande->numero_commande}");
                $this->info("💰 Total : {$commande->total} FCFA");
            } catch (\Exception $e) {
                $this->error('❌ Erreur lors de l\'envoi : ' . $e->getMessage());
                return 1;
            }
        } else {
            // Test simple
            $this->info("Envoi d'un email de test à {$email}...");
            
            try {
                Mail::raw('Ceci est un test d\'envoi d\'email depuis votre application e-commerce.', function($message) use ($email) {
                    $message->to($email)
                            ->subject('Test Email - Votre Boutique E-commerce');
                });
                
                $this->info('✅ Email de test envoyé avec succès !');
                $this->info("📧 Destinataire : {$email}");
            } catch (\Exception $e) {
                $this->error('❌ Erreur lors de l\'envoi : ' . $e->getMessage());
                return 1;
            }
        }

        return 0;
    }
}
