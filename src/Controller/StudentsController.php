<?php

namespace App\Controller;

use App\Entity\Students;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentsController extends AbstractController
{
    #[Route('/students', name: 'app_students')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $students = $doctrine->getRepository(Students::class)->findAll();
        dd($students);
        return $this->render('students/index.html.twig', [
            'students' => $students,
        ]);
    }
    #[Route('/students/create', name: 'app_students_create')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $student = new Students();
        // dd($student);
        $student->setName("Rob");
        $student->setAge("45");
        // dd($student);
        $em->persist($student);
        $em->flush(); #basically the go button for persist

        return new Response("created new student".$student->getID());
    }
}
