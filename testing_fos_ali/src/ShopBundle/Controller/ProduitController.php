<?php


namespace ShopBundle\Controller;


use ShopBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
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


    public function AjouterProduitAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $countPromo=$this->countPromo();
        $countLivr=$this->countLivr();
        $em = $this->getDoctrine()->getManager();
        $Produit = new Produit();
        $form = $this->createForm('ShopBundle\Form\ProduitType', $Produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Produit->setNomfile("3.jpg");
            $Produit->getUploadFile();
            $em->persist($Produit);
            $em->flush();
            return $this->redirectToRoute('Produit_Affiche' );
        }
        return $this->render('ShopBundle:Produit:AjouterProduit.html.twig', array(
            'form' => $form->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr
        ));
    }

    public function AfficheProduitAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $countPromo=$this->countPromo();
        $countLivr=$this->countLivr();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Produit')->findAll();
        return $this->render('ShopBundle:Produit:AfficheProduit.html.twig', array(
            'produit' => $produit,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr


        ));
    }

    public function SupprimerProduitAction($idp)
    {

        $em = $this->getDoctrine()->getManager();
        $Prod = $em->getRepository('ShopBundle:Produit')->find(array("idp" => $idp));
        $em->remove($Prod);
        $em->flush();
        return $this->redirectToRoute('Produit_Affiche');
    }


    public function produitsAction(\Symfony\Component\HttpFoundation\Request $request){
        $countPromo=$this->countPromo();
        $countLivr=$this->countLivr();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Produit')->findAll();
        return $this->render('ShopBundle:Produit:AfficheProduitFront.html.twig', array(
            'produit' => $produit,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr


        ));
    }

    public function ModifierProduitAction(Request $request, $idp)
    { $countLivr=$this->countLivr();
        $countPromo=$this->countPromo();

        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('ShopBundle:Produit')->find($idp);
        $editForm = $this->createForm('ShopBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('Produit_Affiche');
        }

        return $this->render('ShopBundle:Produit:ModifierProduit.html.twig', array(
            'produit' => $produit,
            'form' => $editForm->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr
        ));
    }


    public function rateAction(\Symfony\Component\HttpFoundation\Request $request){
        $data = $request->getContent();
        $obj = json_decode($data,true);

        $em = $this->getDoctrine()->getManager();
        $rate =$obj['rate'];
        $idc = $obj['Produit'];
        $animateur = $em->getRepository("ShopBundle:Produit")->find($idc);
        $note = ($animateur->getRate()*$animateur->getVote() + $rate)/($animateur->getVote()+1);
        $animateur->setVote($animateur->getVote()+1);
        $animateur->setRate($note);
        $em->persist($animateur);
        $em->flush();
        return new Response($animateur->getRate());
    }

    public function AfficheProduitByIdAction(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $countLivr = $this->countLivr();
        $countPromo = $this->countPromo();

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Produit')->findOneBy(array("idp" => $id));
        $categorie = $em->getRepository('ShopBundle:Categorie')->findAll();

        return $this->render('ShopBundle:Categorie:AfficheFrontProduitBYid.html.twig', array(
            'produit' => $produit,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
            'categories'=> $categorie


        ));

    }

}
