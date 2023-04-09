<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }


    #[Route('/student/AddS', name: 'app_studentadds')]

    function AddS(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('app_studentaffiche');

        }
        return $this->render('student/AddS.html.twig', [
            'form' => $form->createView()
        ]);


    }

    #[Route('/student/AfficheSlist', name: 'app_studentaffiche')]
    public function AfficheS(StudentRepository $repository)
    {
        $student = $repository->findAll();
        return $this->render('student/AfficheS.html.twig',
            ['student' => $student]);
    }

    #[Route('student/deleteStatiqueS/{id}', name: 'app_DeleteStatiqueS')]
    public function deleteStatiqueS($id, StudentRepository $repo, ManagerRegistry $doctrine): Response
    {
        $student = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("app_studentaffiche");


    }
    /**
     * @Route ("student/UpdateS/{id}",name="updateS")
     */
    function UpdateS(StudentRepository $repository, $id, Request $request)
    {
        $student = $repository->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("app_studentaffiche");
        }
        return $this->render('student/UpdateS.html.twig',
            [
                'f' => $form->CreateView()
            ]);

    }
    /**
     * @Route ("student/recherche",name="recherche")
     */
   function Recherche(StudentRepository $repository,Request $request)
   {
       $data = $request->get('search');
       $student = $repository->findBy(['nsc' => $data]);
       return $this->render('student/AfficheS.html.twig',
           ['student' => $student]);
   }
}
