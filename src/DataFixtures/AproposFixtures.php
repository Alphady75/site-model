<?php

namespace App\DataFixtures;

use App\Entity\Apropos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AproposFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('user_' . 1);

        $apropo = new Apropos();
        $apropo->setName(' Formel SN');
        $apropo->setEmail('formel-sn@gmail.com');
        $apropo->setWhatsapp("242066686033");
        $apropo->setTelephone("+242066686033");
        $apropo->setBureau("12 Ruelle street Sénégal");
        $apropo->setBoitePostal("15449");
        $apropo->setAnneeExperience("25");
        $apropo->setPresentation("Nous sommes une plateforme dédiée à faciliter le processus de création d'entreprise au Sénégal. En quelques étapes simples, nous collectons les informations et documents nécessaires pour constituer votre dossier, que nous soumettons directement aux organismes compétents.");
        $apropo->setObjectif("Bienvenue sur notre site. Nous nous consacrons à défendre les intérêts des femmes, à promouvoir l'égalité des genres et à soutenir celles qui en ont besoin. Ensemble, nous œuvrons pour un monde où chaque femme peut s'épanouir pleinement et sans entraves. Merci de votre soutien et de votre engagement à nos côtés.");
        $apropo->setMots("Bienvenue sur le site  Formel SN. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officiis, officia ipsum numquam, eaque iusto sit, earum ullam perferendis quos cumque sint possimus vero corrupti modi suscipit eveniet est. Consectetur, aliquam.");
        $apropo->setApropos("Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officiis, officia ipsum numquam, eaque iusto sit, earum ullam perferendis quos cumque sint possimus vero corrupti modi suscipit eveniet est. Consectetur, aliquam.");
        $apropo->setUser($user);
        $apropo->setOnline(true);
        $manager->persist($apropo);

        // Enregistre l'utilisateur dans une référence
        $this->addReference('apropo_' . $apropo->getId(), $apropo);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }
}
