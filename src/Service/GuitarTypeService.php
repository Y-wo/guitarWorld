<?php

namespace App\Service;

use App\Entity\GuitarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class GuitarTypeService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = GuitarType::class;


    public function getGuitarTypeManipulationProcess(
        Request $request
    ) : ?String
    {
        return $request->request->get('guitar_type_manipulation_process') ?? null;
    }

    public function createRequestGuitarTypeAssociativeArray(
        Request $request
    ): array {
        return [
            'version' => $request->request->get('version'),
            'brand' => $request->request->get('brand'),
            'body' => $request->request->get('body'),
            'pickup' => $request->request->get('pickup'),
            'type' => $request->get('type'),
            'saddlewidth' => $request->request->get('saddlewidth'),
            'deleted' => $request->request->get('deleted'),
            'neck' => $request->request->get('neck'),
            'size' => $request->request->get('size'),
            'fretboard' => $request->request->get('fretboard'),
            'scale' => $request->request->get('scale'),
        ];
    }
}