<?php

namespace GuideBundle\Controller;


use GuideBundle\Entity\Specialite;
use GuideBundle\Form\SpecialiteType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class SpecialiteController extends Controller
{
    public function indexAction()
    {
        return new Response("Bonjour mes vies");
    }

    public function homeAction()
    {
        return $this->render('@Guide/Guide/home.html.twig');

    }
    public function ajoutsAction(Request $request)
    {
      $specialite =new Specialite();
      $form=$this->createForm(SpecialiteType::class, $specialite);
      $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        { $em= $this->getDoctrine()->getManager();
            $em->persist($specialite);
            $em->flush();
            return $this->redirectToRoute('specialite_affichers');

        }
      return $this->render('@Guide/Specialite/AjoutS.html.twig' ,array('form'=>$form->createView()));


    }
    public function affichersAction(Request $request)
    {
      $em=$this->getDoctrine()->getManager();
      $specialite=$em->getRepository("GuideBundle:Specialite")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result =$paginator->paginate(
            $specialite,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)

        );
        dump(get_class($paginator));
      return $this->render('@Guide/Specialite/AfficherS.html.twig' ,array('specialite'=>$result));


    }
    public function supprimersAction($id)
    {  $em= $this->getDoctrine()->getManager();
        $specialite=$this->getDoctrine()->getRepository(Specialite::class)->find($id);
        $em->remove($specialite);
        $em->flush();
        return $this->redirectToRoute('specialite_affichers');

    }
    public function updatesAction(Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $specialite=$em->getRepository(Specialite::class)->find($id);

        $form= $this->createForm(SpecialiteType::class, $specialite);
        $form= $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('specialite_affichers');
        }
        return $this->render('@Guide/Specialite/AjoutS.html.twig' , array('form' => $form->createView()));
    }

}
