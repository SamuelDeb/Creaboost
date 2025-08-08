<?php

namespace App\Controller;

use App\Entity\Sujets;
use App\Form\SujetType;
use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
     //entityMAnager : Doctrine : exécuter les requêtes
     private $em;//em=entitymanager
     public function __construct(EntityManagerInterface $em)
     {
         $this->em =$em;
     }

    /**
     * @Route("/forum", name="app_forum")
     */
    public function listerSujets(): Response
    {
        $sujets = $this->em->getRepository(Sujets::class)->findBy(array(),
            array('date' => 'ASC')
        );
     
        return $this->render('sujets/listesSujets.html.twig', [
            'sujets'=>$sujets,
        ]);
    }

     /**
     * @Route("/forum/collegien", name="app_forum_collegien")
     */
    public function forumCollege(): Response
    {
        $collegien = $this->em->getRepository(Sujets::class)->findAll();
        return $this->render('forum/collegien.html.twig', [
            'collegien'=>$collegien,        ]);
    }

     /**
     * @Route("/forum/lyceen", name="app_forum_lyceen")
     */
    public function forumLyceen(): Response
    {
        $lyceen = $this->em->getRepository(Sujets::class)->findAll();
        return $this->render('forum/lyceen.html.twig', [
            'lyceen'=>$lyceen,        ]);
    }

     /**
     * @Route("/forum/ressource", name="app_forum_ressource")
     */
    public function ressource(): Response
    {
        $ressource = $this->em->getRepository(Sujets::class)->findAll();
        return $this->render('forum/ressource.html.twig', [
            'ressource'=>$ressource,        ]);
    }


        /**
     * @Route("forum/sujets/nouveau", name="app_nouveau_sujets")
     */
    public function nouveauSujet(Request $request): Response
    {
        $sujet = new Sujets();
        $form = $this->createForm(SujetType::class, $sujet);
       

        $user = $this->getUser();
        // $userId = $user->getId();
        // $userId = json_decode($user->getId());
        // dd($userId);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sujet = $form->getData();
            // $sujet ->setAuteur($user->getId());
            $sujet->setClasse($this->getUser()->getClasse());
            $sujet->setReponse(0);
            $sujet->setDate(new \DateTime());
            $this->em->persist($sujet);
            $this->em->flush();

            $message = new Messages();
            // $message ->setAuteur($user->getId());

            $message->setSujet($sujet->getId());
            $message->setContenu($form->get('contenu')->getData());
            $message->setDate(new \DateTime());
            $message->setReponse(0);
            $message->setNiveauClasse($this->getUser()->getclasse());

            $this->em->persist($message);
            $this->em->flush();
            $this->addFlash('success', 'Ajout réussi');
            return $this->redirectToRoute('app_forum');
        }
        return $this->render('sujets/nouveau_sujet.html.twig', [
            'form' => $form->createView()
                ]);
                
    }

        /**
     * @Route("forum/sujets/{id}", name="app_afficher_sujets")
     */
    public function voirSujet(Request $request, $id, MessagesRepository $messageRepository): Response
    {

        $sujet = $this->em->getRepository(Sujets::class)->find($id);
        $sujetId = $sujet->getId();
        $reponse = $sujet->getReponse();
        $message = $this->em->getRepository(Messages::class)->findAll(array('sujet' => $sujetId));
        
        // $message = $messageRepository->getMessages($sujetId);
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $message = new Messages();
            $reponse ++;
            $message->setSujet($sujet->getId());
            $message->setContenu($form->get('contenu')->getData());
            $message->setDate(new \DateTime());
            $message->setReponse($reponse);
            $sujet->setReponse($reponse);
            $message->setNiveauClasse($this->getUser()->getclasse());

            $this->em->persist($message);
            $this->em->flush();
            return $this->redirectToRoute('app_afficher_sujets', ['id' => $sujetId]);
        }
        return $this->render('sujets/messages_sujet.html.twig', [
            'sujet'=>$sujet,
            'messages'=>$message,
            'form' => $form->createView()

                ]);
                
    }
}
