<?php


namespace App\Controller;
use App\Entity\Wish;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class WishController extends AbstractController
{
    /**
     * @Route("/",name="wish_list")
     */
    public function index()
    {
        $wishes= $this->getDoctrine()->getRepository(Wish::class)->findAll();
        return $this->render('wishes/index.html.twig', array('wishes' => $wishes));
    }

    /**
     * @Route("/wish/new", name="new_wish")
     * Method({"GET", "POST"})
     */
    public function addNewWish(Request $request) {
        $wish = new Wish();

        $form = $this->createFormBuilder($wish)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('url', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Add',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $wish= $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wish);
            $entityManager->flush();

            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wishes/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/wish/edit/{id}", name="edit_wish")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $wish = new Wish();
        $wish = $this->getDoctrine()->getRepository(Wish::class)->find($id);

        $form = $this->createFormBuilder($wish)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('url', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wishes/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/wish/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Wish::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('wish_list');

    }
}