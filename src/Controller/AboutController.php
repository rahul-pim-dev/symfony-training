<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends AbstractController
{
    public $trainees = [
        "Madhav",
        "Ritesh",
        "Surbhi",
        "Deepak",
        "Ashish",
        "Mohit"
    ];

    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        return $this->render("about/view.html.twig", [
            'trainees' => $this->trainees
        ]);
    }

    #[Route('/about/trainee/{num}', name: 'app_detail')]
    public function detailAction(Request $request, int $num): Response
    {

        if(!isset($this->trainees[($num - 1)])) {
            return $this->redirect("/about");
        }

        $trainee = $this->trainees[($num - 1)];
        

        return $this->render("about/detail.html.twig", [
            'traineeDetails' => [
                'id' => $num,
                'name' => $trainee
            ]
        ]);
    }
}
