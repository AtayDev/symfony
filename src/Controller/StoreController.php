<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Repository\BookRepository;

class StoreController extends AbstractController
{
    /**
     * @Route("/index", name="store")
     */
    
    public function index(BookRepository $repo):Response
    {
    
        $books=$repo->findAll();

        return $this->render('index.html.twig', [
            'books' => $books,
        ]);
    }
    /**
     * @Route("/new", name="new")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $book=new Book();

        $form=$this->createFormBuilder($book)
                   ->add('Title')
                   ->add('Author')
                   ->add('description', TextareaType::class)
                   ->add("writtenAt")
                   ->add('image')
                   ->add('rating', IntegerType::class)
                   ->getForm();


        $form->handleRequest($request);
        dump($request);
        if($form->isSubmitted() && $form->isValid()){
          
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('confirmation');
        }

        return $this->render('add.html.twig', [
            'formBook' => $form->createView(),
        ]);
    }
    /**
     * @Route("/modify", name="modify")
     */
    public function modify(): Response
    {
        return $this->render('modify.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
     /**
     * @Route("/delete", name="delete")
     */
    public function delete(): Response
    {
        return $this->render('delete.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
    /**
     * @Route("/clients", name="clients")
     */
    public function clients(): Response
    {
        return $this->render('clients.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
    /**
     * @Route("/orders", name="orders")
     */
    public function orders(): Response
    {
        return $this->render('orders.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
   /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmation(): Response
    {
        return $this->render('confirmation.html.twig');
    }
   
}
