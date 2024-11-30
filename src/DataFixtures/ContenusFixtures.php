<?php

namespace App\DataFixtures;

use App\Entity\Contenu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContenusFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $contenus = [
            1 => [
                'name' => "Notre mission",
                'type' => "mission",
                'resume' => "Notre mission Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis quasi a in temporibus cumque veritatis repellendus error harum itaque inventore illum quas vel, impedit laboriosam voluptates beatae fugit maiores quisquam.",
            ],
            2 => [
                'name' => 'Notre vision',
                'type' => 'vision',
                'resume' => "Notre vision est celle Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis quasi a in temporibus cumque veritatis repellendus error harum itaque inventore illum quas vel, impedit laboriosam voluptates beatae fugit maiores quisquam.",
            ],
            3 => [
                'name' => "Nos valeurs",
                'type' => "valeur",
                'resume' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis quasi a in temporibus cumque veritatis repellendus error harum itaque inventore illum quas vel, impedit laboriosam voluptates beatae fugit maiores quisquam.",
            ]
        ];

        foreach ($contenus as $key => $value) {
            $contenu = new Contenu();
            $contenu->setName($value['name']);
            $contenu->setDescription($value['resume']);
            $contenu->setType($value['type']);
            $contenu->setIcon($value['type']);
            $manager->persist($contenu);

            // Enregistre la catégorie dans une référence
            $this->addReference('contenu_' . $key, $contenu);
        }

        $manager->flush();
    }
}
