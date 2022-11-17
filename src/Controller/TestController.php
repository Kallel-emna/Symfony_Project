<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use vendor\symfony\frameworkbundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    
    #[Route('/produit/{var}',name:'test_product')]
    public function Test($var)
    {
        return new Response("la liste des produits: ".$var); 
    }
 
    #[Route('/show', name: 'show_test')]
    public function ShowProduct()
    {
        return $this->render("test/show.html.twig");
    }
}