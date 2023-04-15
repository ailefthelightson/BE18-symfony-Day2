<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentsType;
use App\Repository\StudentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/crud/test')]
class CrudTestController extends AbstractController
{
    #[Route('/', name: 'app_crud_test_index', methods: ['GET'])]
    public function index(StudentsRepository $studentsRepository): Response
    {
        return $this->render('crud_test/index.html.twig', [
            'students' => $studentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_crud_test_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentsRepository $studentsRepository): Response
    {
        $student = new Students();
        $form = $this->createForm(StudentsType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentsRepository->save($student, true);

            return $this->redirectToRoute('app_crud_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_test/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_test_show', methods: ['GET'])]
    public function show(Students $student): Response
    {
        return $this->render('crud_test/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Students $student, StudentsRepository $studentsRepository): Response
    {
        $form = $this->createForm(StudentsType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentsRepository->save($student, true);

            return $this->redirectToRoute('app_crud_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_test/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_test_delete', methods: ['POST'])]
    public function delete(Request $request, Students $student, StudentsRepository $studentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $studentsRepository->remove($student, true);
        }

        return $this->redirectToRoute('app_crud_test_index', [], Response::HTTP_SEE_OTHER);
    }
}
