<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 */
class Messages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $reponse;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $niveau_classe;

    /**
     * @ORM\OneToOne(targetEntity=Membres::class, inversedBy="auteur", cascade={"persist", "remove"})
     */
    private $auteur;

    /**
     * @ORM\Column(type="integer")
     */
    private $sujet;

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getReponse(): ?int
    {
        return $this->reponse;
    }

    public function setReponse(int $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

   

    public function getNiveauClasse(): ?string
    {
        return $this->niveau_classe;
    }

    public function setNiveauClasse(string $niveau_classe): self
    {
        $this->niveau_classe = $niveau_classe;

        return $this;
    }

    public function getAuteur(): ?Membres
    {
        return $this->auteur;
    }

    public function setAuteur(?Membres $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getSujet(): ?int
    {
        return $this->sujet;
    }

    public function setSujet(int $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

   
}
