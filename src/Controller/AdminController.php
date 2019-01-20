<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/{id}/edit", name="app_post_edit")
     */
    public function editpost(Request $request, Blog $post)
    {
        $form = $this->createForm('App\Form\BlogFormType', $post);
        $delete_form = $this
            ->get('form.factory')
            ->createNamedBuilder("delete_form")
            ->add('delete', SubmitType::class, [
                'label' => 'Delete',
                'attr' => [
                    'class' => 'btn_del',
                    'onclick' => 'return confirm(\'Уверены, что хотите удалить?\');'
                ],
            ])
            ->getForm();
        $delete_form->handleRequest($request);
        if ($delete_form->isSubmitted() && $delete_form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('home');
        //    return $this->redirectToRoute('app_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
            'delete_form' => $delete_form->createView(),
            'title' => $post->getTitle(),
            'body' => $post->getDescription(),
        ]);
    }
}
