<?php

namespace App\Controller;
use App\Entity\Book;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
       /**
     * @Route("/book/{id}", name="book.detail")
     */
    public function index(Book $book): Response
    {
        return $this->render('book/detail.html.twig', [
            'book' => $book,
        ]);
    }
}
