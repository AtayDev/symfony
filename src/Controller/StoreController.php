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
     * @Route("/", name="product_list")
     */
    
    public function index(BookRepository $repo):Response
    {
    
        $books=$repo->findAll();

        return $this->render('index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/product/new", name="create_product")
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

            //After Saving, Redirect to the home Product List
            return $this->redirectToRoute("product_list");
        }

        return $this->render('add.html.twig', [
            'formBook' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}", name="edit_product")
     */
    public function edit(Book $book, Request $request, EntityManagerInterface $manager): Response
    {
       

        //The Param Convereter Knows exactly wich $book we mean
        //it Selects the book that have the id in /product/{id}
        $form=$this->createFormBuilder($book)
                   ->add('Title')
                   ->add('Author')
                   ->add('description', TextareaType::class)
                   ->add("writtenAt")
                   ->add('image')
                   ->add('rating', IntegerType::class)
                   ->getForm();

                
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($book);
            $manager->flush();

            //After Saving, Redirect to the home Product List
            return $this->redirectToRoute("product_list");
        }


        return $this->render('edit.html.twig', [
            'formEdit' => $form->createView(),
        ]);
    }

    /**
    * @Route("/product/delete/{id}", name="delete_product")
    */
    public function delete(Book $book,EntityManagerInterface $manager): Response
    {
        $manager->remove($book);
        $manager->flush();
        return $this->render('confirmation.html.twig', [
            'title' => $book->getTitle(),
        ]);
    }
    
    
    
    
    
    
    /**
     * @Route("/clients", name="show_clients")
     */
    public function clients(): Response
    {
        return $this->render('clients.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
    /**
     * @Route("/orders", name="show_orders")
     */
    public function orders(): Response
    {
        return $this->render('orders.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }

}
