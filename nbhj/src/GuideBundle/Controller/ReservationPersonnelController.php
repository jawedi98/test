<?php

namespace GuideBundle\Controller;

use AppBundle\Entity\User;

use GuideBundle\Entity\ReservationPersonnel;
use GuideBundle\Entity\Guide;
use Ob\HighchartsBundle\Highcharts\Highchart;

use GuideBundle\Form\ReservationPersonnelType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ReservationPersonnelController extends Controller
{
     public function ajouterAction(Request $request)
     {
         $reservationpersonnel = new ReservationPersonnel();
         $form = $this->createForm(ReservationPersonnelType::class, $reservationpersonnel);
         $form->handleRequest($request);
         if ($form->isSubmitted() and $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($reservationpersonnel);
             $em->flush();

             return $this->redirectToRoute('reservation_afficher');


         }
         return $this->render('@Guide/ReservationPersonnel/AjoutRP.html.twig', array('form' => $form->createView()));






     }
  
     public function afficherAction()
     {    /* if($this->getUser()==null)
     {
         return $this->redirectToRoute("fos_user_security_login"  );
     }
         if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
             return $this->redirectToRoute("fos_user_security_login");
         }
        $user=$this->getDoctrine()->getRepository(User::class)->findOneByEmail($this->getUser()->getEmail());
         if ($$this->getUser()==null)
         {
             return new Response( "pas user");
     }*/
         $repository=$this->getDoctrine()->getManager()->getRepository(ReservationPersonnel::class);
         $reservation=$repository->countFav($this->getUser()->getId());


         return $this->render('@Guide/ReservationPersonnel/listeres.html.twig',
             array(
                 'reservation' => $reservation
             ));

     }

  public function guidechoisieAction(Request $request,$id)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->findOneById($this->getUser()->getId());
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('GuideBundle:ReservationPersonnel')->countFav($user);

        $repository = $this->getDoctrine()->getManager()->getRepository(ReservationPersonnel::class);


        if ($request->isMethod('POST')) {


            $guideschoisie = $this->getDoctrine()->getRepository(Guide::class)->find($id);
            $reservation = new ReservationPersonnel();

            $reservation->setGuide($guideschoisie);
            $reservation->setUser($this->getUser());
            $reservation->setDateDebut(new\DateTime($request->get('datedebut')));
            $reservation->setDateFin(new\DateTime($request->get('datefin')));
            $guideschoisie->setDispo("111");
            $em->persist($reservation);
            $em->flush();
             return $this->redirectToRoute('afficher_reservation' );

        }
        return $this->render('@Guide/ReservationPersonnel/listeres.html.twig',
            array(
                'reservation' => $reservation
            ));



    }
   /*public function affichres()
    {

        if ($this->getUser() == null) {
            return $this->redirectToRoute("fos_user_security_login");
        }
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute("fos_user_security_login");
        }
        $user = $this->getDoctrine()->getRepository(users::class)->findOneByEmail($this->getUser()->getEmail());
        if ($user == null) {
            return new Response("pas user");
        }

        //var_dump($favoris);
        //return new Response( "test");
        return $this->render('@GuideBundle/ReservationPersonnel/listeres.html.twig',
            array(
                'reservation' => $reservation
            ));


    }*/







    public function afficherrpAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $guide = $em->getRepository("GuideBundle:ReservationPersonnel")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $guide,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4)

        );
        dump(get_class($paginator));
        return $this->render('@Guide/ReservationPersonnel/AfficherG.html.twig', ['guide' => $result]);


    }

    public function supprimerRPAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $this->getDoctrine()->getRepository(ReservationPersonnel::class)->find($id);
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('afficher_reservation');

    }

    public function updateRPAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $guide = $em->getRepository(ReservationPersonnel::class)->find($id);
        $form = $this->createForm(ReservationPersonnelType::class, $guide);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
                   }
        return $this->render('@Guide/ReservationPersonnel/ModifRP.html.twig', array('form' => $form->createView()));
    }






}
