<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: "dashboard_action")]
    public function homeAction(): Response
    {
        return $this->render("personal.html.twig");
        // return $this->render("home/view.html.twig");
    }


    #[Route('/sale', name: "sale_action")]
    public function saleAction(): Response
    {
        return $this->render("sale.html.twig");
        // return $this->render("home/view.html.twig");
    }
}
