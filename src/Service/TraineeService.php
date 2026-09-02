<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class TraineeService
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createNewTrainee($data)
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush(); // db save
    }

    public function removeTrainee(string $entityClass, int $id)
    {

        $trainee = $this->entityManager->getRepository($entityClass)->find($id);

        $this->entityManager->remove($trainee);
        $this->entityManager->flush(); // db save
    }

}