<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Blog;

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('App:Blog');
        $blog = $repository->findAll();
        return $this->render('admin/index.html.twig', array(
            'blog' => $blog,
        ));
    }

    /**
     * @Route("/admin/new", name="write")
     */
    public function new(Request $request)
    {
        $blog = new Blog();
        $form = $this->createForm('App\Form\BlogFormType', $blog);
        $form->handleRequest($request);
        if  ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
        }
        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('App:Blog');
        $blog = $repository->find($id);

        $blog->setName('New product name!');
        $blog->flush();

        return $this->redirectToRoute('edit/edit.html.twig', [
            'id' => $blog->getId()
        ]);
    }

    /**
     * @Route("/delete/", name="delete")
     */
    public function delete() {
        $f = 'f';
        return $this->render('delete/delete.html.twig', [
            'f' => $f,
        ]);
    }
}
