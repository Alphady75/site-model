<?php

namespace App\DataFixtures;

use App\Entity\Activite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ActivitesFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $activites = [
            1 => [
                'name' => "E-commerce",
                'slug' => "e-commerce",
            ],
            2 => [
                'name' => "Import-Export",
                'slug' => "import-export",
            ],
            3 => [
                'name' => "Alimentaire / Restauration",
                'slug' => "alimentaire-restauration",
            ],
            4 => [
                'name' => "BTP / Aménagement",
                'slug' => "btp-amenagement",
            ],
            5 => [
                'name' => "Conseil / Consultant",
                'slug' => "conseil-consultant",
            ],
            6 => [
                'name' => "Logiciel SaaS / Applications",
                'slug' => "logiciel-saas-applications",
            ],
            7 => [
                'name' => "Transport",
                'slug' => "transport",
            ],
            8 => [
                'name' => "Autre",
                'slug' => "autre",
            ]
        ];

        foreach ($activites as $key => $value) {
            $activite = new Activite();
            $activite->setName($value['name']);
            $activite->setSlug(strtolower($this->slugger->slug($value['name'])));
            $manager->persist($activite);
            // Enregistre la catégorie dans une référence
            $this->addReference('activite_' . $key, $activite);
        }

        $manager->flush();
    }
}
