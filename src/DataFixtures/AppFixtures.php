<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username,$plainPassword,$role]) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setUsername($username);
            $user->setPassword($password);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);



            $manager->persist($user);
        }
        $manager->flush();
    }
    private function getUserData()
    {
        yield [
            'Baptiste',
            '123456',
            'ROLE_ADMIN'
        ];
        yield [
            'Lea',
            '123456',
            'ROLE_ADMIN'
        ];
        yield [
            'Januka',
            '123456',
            'ROLE_ADMIN'
        ];
        yield [
            'Corentin',
            '123456',
            'ROLE_ADMIN'
        ];
        yield [
            'Vincent',
            '123456',
            'ROLE_ADMIN'
        ];
        yield [
            'Simon',
            '123456',
            'ROLE_USER'
        ];
        yield [
            'Falbala',
            '123456',
            'ROLE_PREMIUM'
        ];
        yield [
          'rh@totalenergies.fr',
          '123456',
          'ROLE_USER'
        ];

    }
}
