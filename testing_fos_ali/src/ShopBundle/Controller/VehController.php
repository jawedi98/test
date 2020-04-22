<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Soc;
use ShopBundle\Entity\Veh;
use ShopBundle\Form\VehType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class VehController extends Controller
{

    public function  countPromo()
    {
        $rest=0;
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository('ShopBundle:Promotion')->findAll();
        foreach ($promo as $p)
        {
            $rest= $rest+1;
        }

        return $rest;
    }
    public function  countLivr()
    {
        $rest=0;
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository('ShopBundle:Livr')->findAll();
        foreach ($promo as $p)
        {
            $rest= $rest+1;
        }

        return $rest;
    }


    public function newAction(Request $request)
    {
        $countLivr = $this->countLivr();
        $countPromo = $this->countPromo();
        $veh = new Veh();
        $form = $this->createForm('ShopBundle\Form\VehType', $veh);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $veh->setStatus('0');
            /** @var UploadedFile $ad */
            $ad = $form->get('ad')->getData();


            if ($ad) {
                $originalFilename = pathinfo($ad->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ad->guessClientExtension();


                try {
                    $ad->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $veh->setAd($newFilename);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($veh);
            $em->flush();

            return $this->redirectToRoute('veh_index');
        }

        return $this->render('@Shop/Veh/new.html.twig', array(
            'veh' => $veh,
            'form' => $form->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));

    }

    public function indexAction(Request $request)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();
        $vehs = $em->getRepository('ShopBundle:Veh')->findAll();
        $vehs = $em->getRepository('ShopBundle:Veh')->editProgAdQB();;

        $listvehs = $this->getDoctrine()->getRepository('ShopBundle:Veh')->findAll();

        $user=$this->getUser();
        if($user)
        {

            if($user->isSuperAdmin() )
                $vehs = $this->get('knp_paginator')->paginate(
                    $listvehs, $request->query->get('page', 1)/*page number*/,
                    2/*limit per page*/
                );
            return $this->render('@Shop/Veh/index.html.twig', array(
                'vehs' => $vehs,
                'countPromo' => $countPromo,
                'countLivr' => $countLivr,

            ));

        }

    }




    /**
     * Finds and displays a veh entity.
     *
     * @Route("/{idad}", name="veh_show")
     * @Method("GET")
     */
    public function showAction($idad)
    { $j=0;
        $m=0;
        $y=0;
        $s=new \DateTime("now");
        $countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();

        $veh = $em->getRepository('ShopBundle:Veh')->find($idad);
        $j= $veh->getDebutcontrat()->diff($veh->getFincontrat(), true)->d;
        $m= $veh->getDebutcontrat()->diff($veh->getFincontrat(), true)->m;
        $y= $veh->getDebutcontrat()->diff($veh->getFincontrat(), true)->y;
        $jj= $veh->getDebutcontrat()->diff($s, true)->d;
        $mm= $veh->getDebutcontrat()->diff($s, true)->m;
        $yy= $veh->getDebutcontrat()->diff($s, true)->y;
        return $this->render('@Shop/Veh/show.html.twig', array(
            'veh' => $veh,
            'j' => $j,
            'm' => $m,
            'y' => $y,
            'jj' => $jj,
            'mm' => $mm,
            'yy' => $yy,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,

        ));

    }
    /**
     * Displays a form to edit an existing veh entity.
     *
     * @Route("/{idad}", name="veh_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $idad)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $veh = $this->getDoctrine()->getRepository(Veh::class)->find($idad);
        $veh->setAd(new File('uploads/images/11-5e440b974a910.jpeg'));


        $form = $this->createForm(VehType::class, $veh);
        $form =$form->handleRequest($request);
        if($form->isSubmitted()){


            $ad = $form->get('ad')->getData();


            if ($ad) {
                $originalFilename = pathinfo($ad->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ad->guessClientExtension();


                try {
                    $ad->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $veh->setAd($newFilename);


            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($veh);
            $em->flush();
            return $this->redirectToRoute('veh_index');
        }
        return $this->render('@Shop/Veh/edit.html.twig', array(
            'form'=>$form->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,));

    }

    /**
     * Displays a form to edit an existing veh entity.
     *
     * @Route("/{idad}", name="veh_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($idad)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(Veh::class)->find($idad);
        $em->remove($form);
        $em->flush();
        return $this->redirectToRoute('veh_index');

    }

  /* public function ajoutertempsAction($idad)
    {
        //test de date if date today is between debut date and fin date --> show + state (programmed/displaying/history)
        $em = $this->getDoctrine()->getManager();
        $form=$em->getRepository(Veh::class)->ajoutertemps($idad);
        $em->flush();
        return $this->redirectToRoute('veh_index');
    }*/

}
