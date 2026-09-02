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
    public function __construct(private \App\Service\TraineeService $traineeService, private EntityManagerInterface $entityManager)
    {
        
    }

    #[Route('/trainee', name: 'app_trainee')]
    public function index(): Response
    {
        $trainees = $this->entityManager
            ->getRepository('App\Entity\Trainee')
            ->findAll();

        return $this->render('trainee/index.html.twig', [
            'controller_name' => 'TraineeController',
            'trainees' => $trainees,
        ]);
    }

    #[Route('/trainee/new', name: 'app_trainee_new', methods: ['GET', 'POST'])]
    public function newTrainee(Request $request): Response
    {

        $requestData = $request->request->all();

        if(isset($requestData['name']) && isset($requestData['email'])) {
            $trainee = new \App\Entity\Trainee();
            $trainee->setName($requestData['name']);
            $trainee->setEmail($requestData['email']);

            $this->traineeService->createNewTrainee($trainee);

            return $this->redirectToRoute('app_trainee');
        }

        return $this->render('trainee/new.html.twig', [
            'controller_name' => 'TraineeController',
        ]);
    }

    #[Route('/trainee/remove/{id}', name: 'app_trainee_remove', methods: ['GET'])]
    public function removeTrainee(Request $request, int $id): Response
    {
        $this->traineeService->removeTrainee('App\Entity\Trainee', $id);

        return $this->redirectToRoute('app_trainee');
    }

    #[Route('/trainee/create', name: 'app_trainee_new', methods: ['GET', 'POST'])]
    public function createTrainee(Request $request): Response
    {
        $trainee = new Trainee();
        $form = $this->createForm(TraineeType::class, $trainee);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $traineeData = $form->getData();

            if(isset($traineeData)) {
                $this->traineeService->createNewTrainee($traineeData);

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
