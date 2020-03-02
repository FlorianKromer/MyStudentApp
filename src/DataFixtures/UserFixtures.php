<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        //admin
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail($faker->email);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin'
        ));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        //random user

        for ($i = 0; $i < 5; ++$i) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'azerty'.$i
            ));
            if (0 == $i % 2) {
                $user->setRoles(['ROLE_STUDENT']);
            } else {
                $user->setRoles(['ROLE_TEACHER']);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
