<?php

namespace App\Controller;

use App\Entity\Trainee;
use App\Form\TraineeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

    #[Route('/trainee/remove/{id}', name: 'app_trainee_remove', methods: ['GET'])]
    public function removeTrainee(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $trainee = $entityManager->getRepository(Trainee::class)->find($id);

        if(!$trainee) {
            throw $this->createNotFoundException('Trainee not found');
        }

        $entityManager->remove($trainee);
        $entityManager->flush(); // db save

        return $this->redirectToRoute('app_trainee');
    }

    #[Route('/trainee/create', name: 'app_trainee_new', methods: ['GET', 'POST'])]
    public function createTrainee(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainee = new Trainee();
        $form = $this->createForm(TraineeType::class, $trainee);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $traineeData = $form->getData();

            if(isset($traineeData)) {
                $entityManager->persist($traineeData);
                $entityManager->flush(); // db save


                $this->addFlash(
                    'traineeCreated',
                    'Your account has been created successfully!'
                );

            }

            return $this->redirectToRoute('app_trainee');
        } else {
            $form->getErrors(true);

            // dd($errors);
        }

        return $this->render("trainee/create.html.twig", [
            'traineeForm' => $form
        ]);
    }
}
