<?php

namespace ShopBundle\Controller;


use ShopBundle\Entity\Question;
use ShopBundle\Repository\QuestionRepository;
use ShopBundle\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOSUserBundle\Entity\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Question controller.
 *
 */
class QuestionController extends Controller
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

    /**
     * Lists all question entities.
     *
     */
    public function indexAction()
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('ShopBundle:Question')->findAll();

        return $this->render('question/index.html.twig', array(
            'questions' => $questions,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }

    /**
     * Lists all question entities.
     *
     */
    public function indexbackAction()
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('ShopBundle:Question')->findAll();

        return $this->render('Question/forum.html.twig', array(
            'questions' => $questions,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }



    /**
     * Creates a new question entity.
     *
     */
    public function newAction(Request $request)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $question = new Question();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('ShopBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $question->setUtilisateur($user);
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('forum');
        }

        return $this->render('@Shop/Question/addQuestion.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }

    /**
     * Creates a new question entity.
     *
     */
    public function frontAction(Request $request)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $question = new Question();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('ShopBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $question->setUtilisateur($user);
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('Forum');
        }

        return $this->render('@Shop/Question/addQuestionfront.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }



    /**
     * Finds and displays a question entity.
     *
     */
    public function showAction(Request $request)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();
        $allQuestions= $em->getRepository(Question::class)->findAll();
        $question =$this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $allQuestions,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("@Shop/Question/forum.html.twig",array(
            "questions" => $question,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     */
    public function showfrontAction(Request $request)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $em = $this->getDoctrine()->getManager();
        $allQuestions= $em->getRepository(Question::class)->findAll();
        $question =$this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $allQuestions,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("@Shop/Question/forumfront.html.twig",array(
            "questions" => $question,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));


    }







    /**
     * Displays a form to edit an existing question entity.
     *
     */
    public function editAction(Request $request, Question $question)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('ShopBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_edit', array('id' => $question->getId(),
                'countPromo' => $countPromo,
                'countLivr' => $countLivr,));
        }

        return $this->render('Question/edit.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ));
    }


    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("/{id}", name="forum_delete")
     * @Method({"GET"})
     */

    public function DeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $q=$em->getRepository(Question::class)->find($id);
        $em->remove($q);
        $em->flush();
        return $this->redirectToRoute('forum');
    }


    public function allPosts(QuestionRepository $repo)
    {$countLivr=$this->countLivr();
        $countPromo=$this->countPromo();
        $posts = $repo->findAll();

        return $this->render('@Shop/Question/Shop.html.twig', [
            'questions' => $posts,
            'countPromo' => $countPromo,
            'countLivr' => $countLivr,
        ]);
    }
    /*public function likeAction(Question $question)
    {
        $em=$this->getDoctrine()->getManager();
        $q=$em->getRepository(PostLike::class);
        $user=$this->getUser();
        if(!$user) return $this->json([
            'code' => 200,
            'message' => 'ca marche'
        ], 200);
        if ($question->isLikedByUser($user)) {
            $like = $q->findOneBy([
                'questions' => $question,
                'user' => $user
            ]);

            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like supprimer',
                'likes' => $q->count(['questions' => $question])
            ], 200);
        }

        $like = new PostLike();
        $like->setIdQuestion($question);
        $like->setIdUser($user);


        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $q->count(['questions' => $question])
        ], 200);
    }
*/
    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('valeur') == '') {
            $questionRep = $em->getRepository(Question::class)->findAll();
        } else {
            $questionRep = $em->getRepository(Question::class)->findBy(['titre' => $request->get('valeur')]);
        }

        // $questionRep = $em->getRepository(Question::class)->findAll();

        $template = $this->render('@Shop/Question/Recherche.html.twig', array(
            'questions' => $questionRep))->getContent();

        $json = json_encode($template);
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }












    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    /* private function createDeleteForm(Question $question)
     {
         return $this->createFormBuilder()
             ->setAction($this->generateUrl('question_delete', array('id' => $question->getId())))
             ->setMethod('DELETE')
             ->getForm()
         ;
     }*/
}