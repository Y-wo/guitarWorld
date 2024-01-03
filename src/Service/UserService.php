<?php

namespace App\Service;

use App\Constants\SystemWording;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AbstractEntityService
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($entityManager);
        $this->passwordHasher = $passwordHasher;
    }

    public static $entityFqn = User::class;

    public function createRequestUserAssociativeArray(
        Request $request
    ): array {
        return [
            'firstname' => $request->request->get('firstname'),
            'lastname' => $request->request->get('lastname'),
            'email' => $request->request->get('email'),
            'email_confirmation' => $request->request->get('email_confirmation'),
            'street' => $request->get('street'),
            'housenumber' => $request->request->get('housenumber'),
            'zipcode' => $request->request->get('zipcode'),
            'city' => $request->request->get('city'),
            'phone' => $request->request->get('phone'),
            'birthday' => new \DateTime($request->request->get('birthday')),
            'createdAt' => new \DateTimeImmutable(),
            'password' => $request->request->get('password'),
            'password_confirmation' => $request->request->get('password_confirmation'),
        ];
    }

    public function getUserManipulationProcess(
        Request $request
    ) : ?String
    {
        return $request->request->get('user_manipulation_process') ?? null;
    }



    public function emailExists(
        String $email,
        bool $onlyActive
    ): bool {
        $query = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r.email')
            ->where('r.email = :email')
            ->setParameter('email', $email)
            ;

        if($onlyActive){
            $query->andWhere('r.deleted = 0');
        }

        $result = $query->getQuery()->execute();
        return count($result) > 0;   
    }

    public function createNewUser(
        array $userInfos
    ) : bool
    {
        $user = new User();

        $hashedPassword = hash('md5', $userInfos['password']);

        $user
            ->setFirstname($userInfos['firstname'])
            ->setLastname($userInfos['lastname'])
            ->setEmail($userInfos['email'])
            ->setStreet($userInfos['street'])
            ->setHouseNumber($userInfos['housenumber'])
            ->setPhone($userInfos['phone'])
            ->setBirthday($userInfos['birthday'])
            ->setCity($userInfos['city'])
            ->setBegin(new \DateTimeImmutable())
            ->setDeleted(0)
            ->setZipcode($userInfos['zipcode'])
            ->setRoles([SystemWording::ROLE_USER])
            ->setPassword($hashedPassword)
        ;

        return $this->store($user) ? true : false;
    }

    public function getUserByEmail(String $email): ?User
    {
        $query = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.email = :email')
            ->andWhere('r.deleted = 0')
            ->setParameter('email', $email)
            ;

        $result = $query->getQuery()->execute();
        return (count($result) > 0 ) ? $result[0] : null;
    }

}