<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClubController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    #[Route('/clublist', name: 'formation_club')]
    public function formations()
    { 
        $var1="A29"; 
        $var2="J23"; 
        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony
            4','Description'=>'pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
            'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
            'nb_participants'=>12));
        return $this->render('club/list.html.twig',array('classe'=>$var1,'salle'=>$var2,'tableDeFormation'=>$formations)) ; 
    }
    #[Route('reservation', name: 'app_reservation')]
    public function reservation(): Response
    {
        return new Response("La formation : ".$_GET['Titre']);
    }
    #[Route('/clubs', name: 'app_club')]
    public function listclub(ClubRepository $repository)
    {
        $clubs=$repository->findAll();
        return $this->render("club/listClub.html.twig", array("tabClub"=>$clubs));
    }

    
}