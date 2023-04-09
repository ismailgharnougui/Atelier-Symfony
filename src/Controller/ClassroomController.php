<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }


    #[Route('/classroom/Affichelist', name: 'app_classroomaffiche')]
    public function Affiche(ClassroomRepository $repository)
    {
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $classroom = $repository->findAll();
        return $this->render('classroom/Affiche.html.twig',
            ['classroom' => $classroom]);
    }


    #[Route('classroom/addStatique', name: 'app_addStatique')]
    public function addStatique(ClassroomRepository $repository): Response
    {
        //1 preparer mon objet
        $classroom1 = new Classroom();
        $classroom1->setName("Class 3A5");
        $classroom1->setNbetudiant(32);

        $classroom2 = new Classroom();
        $classroom2->setName("Class 3A6");
        $classroom2->setNbetudiant(30);
        //2ajout de l'objet
        $repository->save($classroom1);
        $repository->save($classroom2, true);
        return $this->redirectToRoute("app_classroomaffiche");

    }

    #[Route('classroom/addStatique2', name: 'app_addStatique2')]
    public function addStatique2(ManagerRegistry $doctrine): Response
    {
        //1 preparer mon objet
        $classroom1 = new Classroom();
        $classroom1->setName("Class 3A5");
        $classroom1->setNbetudiant(32);

        $classroom2 = new Classroom();
        $classroom2->setName("Class 3A6");
        $classroom2->setNbetudiant(30);
        //2ajout de l'objet
        $em = $doctrine->getManager();
        $em->persist($classroom1);
        $em->persist($classroom2);

        $em->flush();
        //3- redirection vers la liste des classrooms
        return $this->redirectToRoute("app_classroomaffiche");

    }

    #[Route('classroom/deleteStatique/{id}', name: 'app_DeleteStatique')]
    public function deleteStatique($id, ClassroomRepository $repo, ManagerRegistry $doctrine): Response
    {
        $classroom = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute("app_classroomaffiche");


    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("classroom/Add")
     */
    function Add(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('app_classroomaffiche');

        }
        return $this->render('classroom/Add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("classroom/Update/{id}",name="update")
     */
    function Update(ClassroomRepository $repository, $id, Request $request)
    {
        $classroom = $repository->find($id);
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("app_classroomaffiche");
        }
        return $this->render('classroom/Update.html.twig',
            [
                'f' => $form->CreateView()
            ]);

    }


}


