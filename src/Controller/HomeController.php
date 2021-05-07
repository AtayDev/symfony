<?php
namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }
}
