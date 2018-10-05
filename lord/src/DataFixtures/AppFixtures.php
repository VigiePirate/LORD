<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\DataFixtures\Data;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach (Data::USERS as $user) {
            $userEntity = new User();
            $userEntity
                ->setUsername($user['username'])
                ->setEmail($user['email'])
                ->setPassword($user['password'])
                ->setRoles($user['roles']);

            $manager->persist($userEntity);
        }
        $manager->flush();
    }
}
