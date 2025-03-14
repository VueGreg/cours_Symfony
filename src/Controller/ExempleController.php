<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExempleController extends AbstractController
{
    #[Route('/example', name: 'example')]
    public function index(): Response
    {
        return $this->render('example/index.html.twig', [
            'message' => 'Bonjour Symfony !'
        ]);
    }
}