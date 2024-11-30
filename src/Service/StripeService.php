<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Customer;

class StripeService
{
   private $stripeSecretKey;
   private $domaine;

   public function __construct(
      private EntityManagerInterface $entityManager
   ) {
      /**
       * Vérification de l'environnement
       */
      if ($_ENV['APP_ENV'] === 'dev') {
         $this->stripeSecretKey = $_ENV['STRIPE_SECRET_KEY_TEST'];
      } else {
         $this->stripeSecretKey = $_ENV['STRIPE_SECRET_KEY_LIVE'];
      }

      $this->domaine = $_ENV['SITE_DOMAINE'];
   }

   public function payer(Commande $commande, int $amount, string $urlToRedirect, string $urlToCancel)
   {
      Stripe::setApiKey($this->stripeSecretKey);
      $token = 'FORMEL-SN' . uniqid(md5('token'));

      // Créer un client Stripe
      $client = Customer::create([
         'email' => $commande->getEmail(),
         'name' => $commande->getNom() .' '. $commande->getPrenom(),
      ]);

      $name = $commande->getName();

      $checkout_session = Session::create([
         'payment_method_types' => ['card'],
         'customer' => $client->id,
         'line_items' => [[
            'price_data' => [
               'currency' => 'xof',
               'unit_amount' => $amount,
               'product_data' => [
                  'name' => $name,
               ],
            ],
            'quantity' => 1
         ]],
         'mode' => 'payment',
         'success_url' => $this->domaine . $urlToRedirect . '?token=' . $token,
         'cancel_url' => $this->domaine . $urlToCancel,
      ]);

      return $checkout_session->url;
   }

   /*public function abonnement(
      string $websiteDomaine,
      EntityStripe $stripeAbonnement,
      User $user = null
   ) {

       $checkout_session = \Stripe\Checkout\Session::create([
         'success_url' => $websiteDomaine . '/save/' . $stripeAbonnement->getStripeKey(),
         'cancel_url' => $websiteDomaine . '/cancel',
         'allow_promotion_codes' => true,
         'payment_method_types' => ['card'],
         'mode' => 'subscription',
         'line_items' => [[
            'price' => $stripeAbonnement->getStripeKey(),
            'quantity' => 1,
         ]],
         "customer_email" => $user->getEmail()
      ]);

      return $checkout_session;
   }*/

   public function convertAmountToEuro(int $amount)
   {
      //$paramtre = $this->parametreRepository->findOneBy(['active' => true]);
      $base = 650;

      /*if ($paramtre)
         $base = $paramtre->getEuroVariation();*/

      $montant = $amount / $base;
      $roundedMontant = round($montant, 2);

      return $roundedMontant;
   }
}
