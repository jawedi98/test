<?php

namespace GuideBundle\Controller;

use AppBundle\Entity\User;

use GuideBundle\Entity\ReservationPersonnel;
use GuideBundle\Entity\AffectationGuide;
use GuideBundle\Entity\Guide;
use Ob\HighchartsBundle\Highcharts\Highchart;

use GuideBundle\Form\ReservationPersonnelType;
use GuideBundle\Form\AffectationGuideType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AffectationGuideController extends Controller
{
     public function ajouterAction(Request $request)
     {
         $affectation = new AffectationGuide();
         $form = $this->createForm(AffectationGuideType::class, $affectation);
         $form->handleRequest($request);
         if ($form->isSubmitted() and $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($affectation);
             $em->flush();
             $a=$affectation->getGuide();
             $a->setDispo("non");
             return $this->redirectToRoute('afficher_aff');

         }

         return $this->render('@Guide/Affectation/AjoutA.html.twig', array('form' => $form->createView()));





     }
     public function afficherEAction(Request $request)
     {

         $em = $this->getDoctrine()->getManager();
         $aff = $em->getRepository("GuideBundle:AffectationGuide")->findAll();

         /**
          * @var $paginator \Knp\Component\Pager\Paginator
          */
         $paginator = $this->get('knp_paginator');
         $result = $paginator->paginate(
             $aff,
             $request->query->getInt('page', 1),
             $request->query->getInt('limit', 4)

         );
         dump(get_class($paginator));
         return $this->render('@Guide/Affectation/AfficherA.html.twig', ['aff' => $result]);

     }
  


    public function supprimerAAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $this->getDoctrine()->getRepository(AffectationGuide::class)->find($id);
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('afficher_aff');

    }









    public function updateAFAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $affectation = $em->getRepository(AffectationGuide::class)->find($id);

        $form = $this->createForm(AffectationGuideType::class, $affectation);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('afficher_aff');
        }
        return $this->render('@Guide/Affectation/ModifA.html.twig', array('form' => $form->createView()));
    }






}
