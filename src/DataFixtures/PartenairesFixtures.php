<?php

namespace App\DataFixtures;

use App\Entity\Partenaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PartenairesFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $partenaires = [
            1 => [
                'name' => "Le plus simple, le plus rapide",
            ],
            2 => [
                'name' => "La banque des entrepreneurs",
            ],
            3 => [
                'name' => "Un autre établissement ?",
            ]
        ];

        foreach ($partenaires as $key => $value) {
            $partenaire = new Partenaire();
            $partenaire->setName($value['name']);
            $partenaire->setSlug(strtolower($this->slugger->slug($value['name'])));
            $partenaire->setOnline(true);
            $manager->persist($partenaire);
            // Enregistre la catégorie dans une référence
            $this->addReference('partenaire_' . $key, $partenaire);
        }

        $manager->flush();
    }
}
