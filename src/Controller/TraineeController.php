<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TraineeController extends AbstractController
{
    #[Route('/trainee', name: 'app_trainee')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $trainees = $entityManager
            ->getRepository('App\Entity\Trainee')
            ->findAll();

        return $this->render('trainee/index.html.twig', [
            'controller_name' => 'TraineeController',
            'trainees' => $trainees,
        ]);
    }

    #[Route('/trainee/new', name: 'app_trainee_new', methods: ['GET', 'POST'])]
    public function newTrainee(Request $request, EntityManagerInterface $entityManager): Response
    {

        $requestData = $request->request->all();

        if(isset($requestData['name']) && isset($requestData['email'])) {
            $trainee = new \App\Entity\Trainee();
            $trainee->setName($requestData['name']);
            $trainee->setEmail($requestData['email']);

            $entityManager->persist($trainee);
            $entityManager->flush(); // db save

            return $this->redirectToRoute('app_trainee');
        }

        return $this->render('trainee/new.html.twig', [
            'controller_name' => 'TraineeController',
        ]);
    }
}
