<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServicesFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $service = new Service();
        $service->setName("Création d'entreprise");
        $service->setTarif(50000);
        $service->setResume("Lorem ipsum, dolor sit amet consectetur adipisicing elit. Architecto quia asperiores rerum distinctio vero eaque blanditiis, magnam eius ipsa sequi aliquid nesciunt officiis facere nisi nam? Nisi ad ipsam velit.");
        $service->setDescription("Lorem ipsum, dolor sit amet consectetur adipisicing elit. Architecto quia asperiores rerum distinctio vero eaque blanditiis, magnam eius ipsa sequi aliquid nesciunt officiis facere nisi nam? Nisi ad ipsam velit.");
        $service->setOnline(true);
        $service->setSlug(strtolower($this->slugger->slug("Création d'entreprise")));
        $manager->persist($service);
        $this->addReference('service_' . 1, $service);

        $manager->flush();
    }
}
