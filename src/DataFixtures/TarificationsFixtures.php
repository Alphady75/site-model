<?php

namespace App\DataFixtures;

use App\Entity\Tarification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TarificationsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $tarifications = [
            1 => [
                'name' => "Premium",
                "tarif" => 50000,
                "resume" => "+ 259,39 FCFA de frais de greffe et de publication  Formel SN",
                "recommander" => false,
            ],
            2 => [
                'name' => 'Standard',
                "tarif" => 20000,
                "resume" => "+ 259,39 FCFA de frais de greffe et de publication  Formel SN",
                "recommander" => false,
            ],
            3 => [
                'name' => "Starter",
                "tarif" => 15000,
                "resume" => "+ 259,39 FCFA de frais de greffe et de publication  Formel SN",
                "recommander" => true,
            ]
        ];

        foreach ($tarifications as $key => $value) {
            $tarification = new Tarification();
            $tarification->setName($value['name']);
            $tarification->setCout($value['tarif']);
            $tarification->setTypeCout('HT');
            $tarification->setDescription($value['resume']);
            $tarification->setRecommander(true);
            $tarification->setOnline(true);
            $manager->persist($tarification);
            // Enregistre la catégorie dans une référence
            $this->addReference('tarification_' . $key, $tarification);
        }

        $manager->flush();
    }
}
