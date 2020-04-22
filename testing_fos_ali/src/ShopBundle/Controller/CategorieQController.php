<?php


namespace ShopBundle\Controller;


use ShopBundle\Entity\CategorieQ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategorieQController extends Controller
{

    public function ParentAction()
    {

        $em = $this->getDoctrine()->getManager();
        $categorieqs = $em->getRepository('ShopBundle:CategorieQ')->findAll();
        $question = $em->getRepository('ShopBundle:Question')->findAll();
        return $this->render('ShopBundle:CategorieQ:index.html.twig', array(
            'question' => $question,
            'categorieqs' => $categorieqs,

        ));    }

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
    public function createcategorieAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();
        $categorieq = new CategorieQ();
        $form = $this->createForm('ShopBundle\Form\CategorieQType', $categorieq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorieq);
            $em->flush();
            return $this->redirectToRoute('Categorieq_Affiche');
        }

        return $this->render('ShopBundle:CategorieQ:AjouterCategories.html.twig', array(
            'categorieq' => $categorieq,
            'form' => $form->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,


        ));

    }

    public function AfficheCategoriesAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $countLivr=$this->countLivr();
        $countPromo=$this->countPromo();

        $em = $this->getDoctrine()->getManager();
        $categorieqs = $em->getRepository('ShopBundle:CategorieQ')->findAll();
        return $this->render('ShopBundle:CategorieQ:AfficheCategories.html.twig', array(
            'categorieqs' => $categorieqs,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,


        ));
    }

    public function SupprimerCategoriesAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $catq = $em->getRepository('ShopBundle:CategorieQ')->find(array("id" => $id));
        $em->remove($catq);
        $em->flush();
        return $this->redirectToRoute('Categorieq_Affiche');
    }



}