<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\commande_produit;
use ShopBundle\Entity\commandeP;
use ShopBundle\Entity\panier_produit;
use ShopBundle\Form\PanierType;
use ShopBundle\Entity\Panier;
use ShopBundle\Form\commandePType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * commandeP controller.
 *
 */
class commandePController extends Controller
{public function  countPromo()
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




    /**
     * Lists all commandeP entities.
     *
     */

    public function indexAction()
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();

        $commandePs = $em->getRepository('ShopBundle:commandeP')->findAll();

        return $this->render('@Shop/CommandeP/frontindex.html.twig', array(
            'commandePs' => $commandePs,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }

    /**
     * Creates a new commandeP entity.
     *
     */
    public function newAction(Request $request)
    {
        $commandeP = new commandeP();
        $form = $this->createForm('ShopBundle\Form\commandePType', $commandeP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandeP);
            $em->flush();

            return $this->redirectToRoute('comfront_index', array('idcm' => $commandeP->getIdcm()));
        }

        return $this->render('@Shop/CommandeP/frontnew.html.twig', array(
            'commandeP' => $commandeP,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commandeP entity.
     *
     */
    public function showAction(commandeP $commandeP)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $deleteForm = $this->createDeleteForm($commandeP);

        return $this->render('@Shop/CommandeP/frontshow.html.twig', array(
            'commandeP' => $commandeP,
            'delete_form' => $deleteForm->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }

    /**
     * Displays a form to edit an existing commandeP entity.
     *
     */
    public function editAction(Request $request, commandeP $commandeP)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $deleteForm = $this->createDeleteForm($commandeP);
        $editForm = $this->createForm('ShopBundle\Form\commandePType', $commandeP);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comfront_edit', array('idcm' => $commandeP->getIdcm()));
        }

        return $this->render('@Shop/CommandeP/frontedit.html.twig', array(
            'commandeP' => $commandeP,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }

    /**
     * Deletes a commandeP entity.
     *
     */
    /**
     * Displays a form to edit an existing commandeP entity.
     *
     * @Route("/{idcm}", name="comfront_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($idcm)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(commandeP::class)->find($idcm);
        $em->remove($form);
        $em->flush();
        return $this->redirectToRoute('comfront_index');

    }


    /**
     * Creates a form to delete a commandeP entity.
     *
     * @param commandeP $commandeP The commandeP entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(commandeP $commandeP)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comfront_delete', array('idcm' => $commandeP->getIdcm())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function panierAction(){
        $em = $this->getDoctrine()->getManager();

        $panier = $em->getRepository('ShopBundle:Panier')->findOneBy(array("User"=>$this->getUser()));
        if ($panier == null) {
            $panier = new Panier();
            $panier->setUser($this->getUser());
            $panier->setQuantite(0);
            $panier->setSomme(0);
            $em->persist($panier);
            $em->flush();
        }
        $panier_produit = $em->getRepository('ShopBundle:panier_produit')->findBy(array("panier"=>$panier));


        return $this->render('ShopBundle:CommandeP:AffichePanier.html.twig', array(
            "produits"=>$panier_produit
        ));
    }

    public function delete_produitAction($id){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Produit')->find($id);
        $panier = $em->getRepository('ShopBundle:Panier')->findOneBy(array("User"=>$this->getUser()));
        $panier_produit = $em->getRepository('ShopBundle:panier_produit')->findOneBy(array("panier"=>$panier, "produit"=>$produit));
        if ($panier_produit == null)
            throw new NotFoundHttpException();
        $em->remove($panier_produit);
        $em->flush();
        return $this->redirectToRoute("panier_front");
    }

    public function commandeAction(){
        $em = $this->getDoctrine()->getManager();
        $panier = $em->getRepository('ShopBundle:Panier')->findOneBy(array("User"=>$this->getUser()));
        $panier_produit = $em->getRepository('ShopBundle:panier_produit')->findBy(array("panier"=>$panier));
        $commande = new commandeP();
        $commande->setDate(new \DateTime());
        $commande->setIdn($panier);
        $somme_tmp = 0;
        foreach ($panier_produit as $item){
            $commande_produit = new commande_produit();
            $commande_produit->setQte($item->getQte());
            $commande_produit->setProduit($item->getProduit());
            $commande_produit->setCommande($commande);
            $em->persist($commande_produit);
            $somme_tmp += $item->getProduit()->getPrix()*$item->getQte() ;
            $em->remove($item);
        }
        $commande->setSomme($somme_tmp);
        $em->persist($commande);
        $em->flush();

        return $this->redirectToRoute("panier_front");
    }





    public function commandeAdminAction(){
        $countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository('ShopBundle:commandeP')->findAll();

        return $this->render('@Shop/CommandeP/commandeAdmin.html.twig', array(
            'com' => $com,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));

    }

    public function excelAction()
    {
        $countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();

        $comds = $em->getRepository('ShopBundle:commandeP')->findAll();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("insaf")
            ->setLastModifiedBy("insaf")
            ->setTitle("commande")
            ->setSubject("liste des commandes")
            ->setDescription("")
            ->setKeywords("commande panier produit")
            ->setCategory("result file");
        for ($i=0; $i< count($comds); $i++){
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), strval($comds[$i]->getIdcm()))
                ->setCellValue('B'.($i+1),strval( $comds[$i]->getSomme()))
                ->setCellValue('C'.($i+1),strval( $comds[$i]->getIdn()->getUser()->getUsername()))
                ->setCellValue('D'.($i+1),$comds[$i]->getDate()->format('Y-m-d H:i:s'));
        }

        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    public function add_produitAction($id){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Produit')->find($id);
        $panier = $em->getRepository('ShopBundle:Panier')->findOneBy(array("User"=>$this->getUser()));
        if ($panier == null) {
            $panier = new Panier();
            $panier->setUser($this->getUser());
            $panier->setQuantite(0);
            $panier->setSomme(0);
            $em->persist($panier);
            $em->flush();
        }
        $panier_produit = $em->getRepository('ShopBundle:panier_produit')->findOneBy(array("panier"=>$panier, "produit"=>$produit));

        if ($panier_produit == null ){
            $panier_produit = new panier_produit();
            $panier_produit->setPanier($panier);
            $panier_produit->setProduit($produit);
            $panier_produit->setQte(1);
            $em->persist($panier_produit);
            $em->flush();
        }

        else {
            $panier_produit->setQte($panier_produit->getQte()+1);
            $em->flush();
        }
        return $this->redirectToRoute("produit_front");
    }


}