<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has('count')) {
            $session->set('count', 4);
            $session->set('1', 0);
            $session->set('2', 0);
            $session->set('3', 0);
            $session->set('isGameOver', 0);
            $session->set('allFound', 0);
        }
        return $this->render('home/home.html.twig');
    }
}
