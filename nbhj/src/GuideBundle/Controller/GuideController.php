<?php

namespace GuideBundle\Controller;

use EspritBundle\Entity\Formation;
use GuideBundle\Entity\ReservationPersonnel;
use GuideBundle\Form\ReservationPersonnelType;
use Ob\HighchartsBundle\Highcharts\Highchart;

use GuideBundle\Form\GuideType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use GuideBundle\Entity\Guide;

class GuideController extends Controller
{
    public function indexAction()
    {
        return new Response("Bonjour mes vies");
    }

    public function homeAction()
    {
        return $this->render('@Guide/Guide/home.html.twig');

    }

    public function homexAction()
    {
        return $this->render('@Guide/Guide/template.html.twig');

    }

    public function calendrierAction()
    {
        return $this->render('@Guide/Guide/home.html.twig');

    }

    public function ajoutgAction(Request $request)
    {
        $guide = new Guide();
        $form = $this->createForm(GuideType::class, $guide);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($guide);
            $em->flush();
            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom(array('azizjawedi712@gmail.com' => "altf4ADMIN"))
                ->setTo($guide->getAdresse())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('@Guide/Guide/validation.html.twig',array('utilisateur' => $guide->getNom())));

            $this->get('mailer')->send($message);
            return $this->redirectToRoute('guide_afficherg');


        }

        return $this->render('@Guide/Guide/AjoutG.html.twig', array('form' => $form->createView()));


    }

    public function afficherGuideAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $guide = $em->getRepository("GuideBundle:Guide")->findAll();
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
        return $this->render('@Guide/Guide/AfficherG.html.twig', ['guide' => $result]);


    }

    public function supprimerGuideAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $guide = $this->getDoctrine()->getRepository(Guide::class)->find($id);
        $em->remove($guide);
        $em->flush();
        return $this->redirectToRoute('guide_afficherg');

    }
    public function listeresAction($id)
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
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('GuideBundle:ReservationPersonnel')->countFav3($id);

        return $this->render('@Guide/ReservationPersonnel/listeres.html.twig',
            array(
                'reservation' => $reservation
            ));

    }

    public function updateGuideAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $guide = $em->getRepository(Guide::class)->find($id);

        $form = $this->createForm(GuideType::class, $guide);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('guide_afficherg');
        }
        return $this->render('@Guide/Guide/ModifG.html.twig', array('form' => $form->createView()));
    }
    public function statAction(){
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('Le nombre de guides par spécialité');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $em = $this->getDoctrine()->getManager();
        $query=$em->createQuery("select s.nom, count(g.id)total  from GuideBundle:Guide g join g.specialite s group by s.nom")->setMaxResults(4);
        $result=$query->getResult();

        $data =array();

       foreach ($result as $row)
       {
        $a=array($row['nom'],intval($row['total']));
        array_push($data, $a);
       }

        $ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data)));
        return $this->render('@Guide/Statistics/stat.html.twig', array(
            'chart' => $ob ));
    }

    public function afficherGuideFrontAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $guide=$em->getRepository("GuideBundle:Guide")->findAll();

        return $this->render('@Guide/Guide/offers.html.twig' ,['guide'=>$guide]);

    }
    public function choisirguideAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository(Guide::class);
        $guide = $repository->myFind($id);


        $res = $em->getRepository(ReservationPersonnel::class);
       // $guide=$em->getRepository("GuideBundle:ReservationPersonnel")->findAll();
        $form = $this->createForm(ReservationPersonnelType::class, $res);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

        }
        return $this->render('@Guide/ReservationPersonnel/AjoutRP.html.twig', array('guide' => $guide, 'form' => $form->createView()));
    }





}
