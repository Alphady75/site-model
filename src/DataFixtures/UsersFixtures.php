<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder, private SluggerInterface $slugger)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom('Admin');
        $user->setPrenom('demo');
        $user->setCompte('admin');
        $user->setEmail('admin@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->encoder->hashPassword($user, 'azerty'));
        $manager->persist($user);

        // Enregistre l'utilisateur dans une référence
        $this->addReference('user_' . 1, $user);

        $manager->flush();
    }
}
