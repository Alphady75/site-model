<?php

namespace App\DataFixtures;

use App\Entity\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class StatutsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $statuts = [
            1 => [
                'name' => "SASU",
            ],
            2 => [
                'name' => 'SAS',
            ],
            3 => [
                'name' => "SARL 3 ASSOCIES",
            ],
            4 => [
                'name' => "GIE",
            ],
            5 => [
                'name' => "ENTREPRISE INDIVIDUELLE",
            ],
            6 => [
                'name' => "SA",
            ],
            7 => [
                'name' => "SNC",
            ]
        ];

        foreach ($statuts as $key => $value) {
            $statut = new Statut();
            $statut->setName(strtoupper($value['name']));
            $statut->setDescription("Lorem ipsum, dolor sit amet consectetur adipisicing elit. Architecto quia");
            $manager->persist($statut);
            // Enregistre la catégorie dans une référence
            $this->addReference('statut_' . $key, $statut);
        }

        $manager->flush();
    }
}
