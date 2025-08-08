<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{

      //entityMAnager : Doctrine : exécuter les requêtes
      private $em;//em=entitymanager
      public function __construct(EntityManagerInterface $em)
      {
          $this->em =$em;
      }

      
    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new Membres();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $userexiste = $this->em->getRepository(Membres::class)->findOneBy(['pseudo' => $user->getPseudo()]);
            if(!$userexiste){
            $pwdHash = $passwordHasher->hashPassword($user,$user->getPassword());
            $user->setPassword($pwdHash);
            
            $user->setClasse("1ere");
            $user ->setAvatar("profil_defaut.jpeg");
            $user->setRoles(["ROLE_USER"]);
            $user->setGrade("Utilisateur");
            $user->setMeilleurScore(0);
            $user->setXp(0);
            $user->setProfil("");

            $this->em->persist($user);
            $this->em->flush();

        
            $this->addFlash('success', 'Insciption réussi');
            return $this->redirectToRoute('app_accueil');
        }else{
            $this->addFlash('error', 'le pseudo est déjà utiliser');
            return $this->redirectToRoute('app_inscription');
        }
        }

        return $this->render('inscription/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
