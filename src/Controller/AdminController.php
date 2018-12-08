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
//        $em = $this->getDoctrine()->getManager()->getRepository('App:Blog');
        $repository = $this->getDoctrine()->getManager()->getRepository('App:Blog');
        $blog = $repository->findAll();
//        $blog = $em->getRepository('App:Blog')->findBy(['id' => 'DESC']);
        return $this->render('admin/index.html.twig', array(
            'blog' => $blog,
        ));
    }

    /**
     * @Route("/admin/new", name="new")
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
}
