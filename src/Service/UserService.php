<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = User::class;

    // public function getAllUsers() :array
    // {
    //     $queryBuilder = $this
    //         ->entityManager
    //         ->getRepository(self::$entityFqn)
    //         ->createQueryBuilder('r')
    //         ->select('r')
    //         ->where('r.deleted = 0')
    //     ;

    //     $query = $queryBuilder->getQuery();
    //     $members = $query->execute();
    //     return $members;
    // }


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



}