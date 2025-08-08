<?php

namespace App\Controller;

use App\Entity\Sujets;
use App\Entity\Messages;
use App\Form\MessageType;
use Symfony\Component\Mime\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{


    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/messages/update/{id}", name="app_messages_update")
     */
    public function updateMessage(Request $request, $id): Response
    {
        $message = $this->em->getRepository(Messages::class)->find($id);
        $sujetId = $message->getSujet();
        $sujet =  $this->em->getRepository(Sujets::class)->find($sujetId);

        $form = $this->createForm(MessageType::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setContenu($form->get('contenu')->getData());
            $this->em->persist($message);
            $this->em->flush();
            $this->addFlash('success', 'Modification réussi');
            return $this->redirectToRoute('app_afficher_sujets', ['id' => $sujetId]);
        }
        return $this->render('sujets/update_message.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/messages/delete/{id}", name="app_messages_delete")
     */
    public function deleteMessage($id): Response
    {
        $messages = $this->em->getRepository(Messages::class)->find($id);
        $sujetId = $messages->getSujet();
        $sujet =  $this->em->getRepository(Sujets::class)->find($sujetId);

        $reponse = $sujet->getReponse();
        $reponse--;
        $sujet->setReponse($reponse);
        $this->em->remove($messages);
        $this->em->persist($sujet);
        $this->em->flush();

        return $this->redirectToRoute('app_afficher_sujets', ['id' => $sujetId]);
    }
}
