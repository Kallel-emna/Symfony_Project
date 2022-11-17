<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Form\StudentType;
use App\Form\SearchStudentType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClassroomRepository;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/students', name: 'list_student')]
    public function liststudent(StudentRepository $repository, Request $request)
    {
        $students=$repository->findAll();

        $sortByMoyenne=$repository->sortByMoyenne();
        $formSearch= $this->createForm(SearchStudentType::class);
        $formSearch->handleRequest($request);
        $topStudents= $repository->topStudents();
        if ($formSearch->isSubmitted())
        {
            $nce=$formSearch->getData();
          //  var_dump($nce).die();
            $result=$repository->searchStudent($nce);
            return $this->renderForm("student/listStudent.html.twig",
            array("tabStudent"=>$result,
                   "sortByMoyenne"=>$sortByMoyenne,
                   "searchForm"=>$formSearch, "topStudents"=>$topStudents));
        }
        return $this->renderForm("student/listStudent.html.twig",
        array("tabStudent"=>$students,
         "sortByMoyenne"=>$sortByMoyenne,
         "searchForm"=>$formSearch,
         "topStudents"=>$topStudents));
    }


    #[Route('/addForm', name: 'add2')]
    public function addForm(ManagerRegistry $doctrine,Request $request)
    {
        $student= new Student;
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
             $em= $doctrine->getManager();
             $em->persist($student);
             $em->flush();
             return  $this->redirectToRoute("list_student");
         }
        return $this->renderForm("student/add.html.twig",array("formStudent"=>$form));
    }
    

    #[Route('/updateForm/{nce}', name: 'update2')]
    public function  updateForm($nce,StudentRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $student= $repository->find($nce);
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_student");
        }
        return $this->renderForm("student/update.html.twig",array("formStudent"=>$form));
    }

    #[Route('/removeForm/{nce}', name: 'remove2')]

    public function removeStudent(ManagerRegistry $doctrine,$nce,StudentRepository $repository)
    {
        $student= $repository->find($nce);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return  $this->redirectToRoute("list_student");
    }

    #[Route('/addForm', name: 'add')]
    public function addStudent(ManagerRegistry $doctrine,Request $request,StudentRepository $repository)
    {
        $student=new Student();
        $form=$this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $repository->add($student, true);
            return $this->redirectToRoute("list_student");
        }
        return $this->renderForm("student/add2.html.twig",array("formStudent"=>$form));
    }

}
