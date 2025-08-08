<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\UpdateProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembresController extends AbstractController
{

    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    
    /**
     * @Route("/membres/update/{id}", name="app_membres_update")
     */
    public function updateProfil(Request $request, $id): Response
    {
        $user= $this->em->getRepository(Membres::class)->find($id); 
        $form = $this->createForm(UpdateProfilType::class, $user);
       
        
            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid()){
                $file = $form['avatar']->getData();
                $user ->setAvatar($someFilename = uniqid().'.'.$file->guessExtension());
                $directory = "../public/assets/images/avatar";
            
                $file->move($directory, $someFilename);
                $this->em->flush();
                
            $this->addFlash('success', 'Le profil à été modifier');
            return $this->redirectToRoute('app_accueil');
            }
           
        
      
        return $this->render('membres/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/membres/liste", name="app_membres_liste")
     */
    public function listeMembres(): Response
    {
        $user= $this->em->getRepository(Membres::class)->findAll(); 
        
        return $this->render('membres/liste.html.twig', [
            'user' => $user
        ]);
    }
}
