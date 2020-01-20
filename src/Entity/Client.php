<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $client_last;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $client_first;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Work", mappedBy="client_id")
     */
    private $works;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="id")
     */
    private $parent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;


    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function __construct()
    {
        $this->works = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClientLast(): ?string
    {
        return $this->client_last;
    }

    public function setClientLast(?string $client_last): self
    {
        $this->client_last = $client_last;

        return $this;
    }

    public function getClientFirst(): ?string
    {
        return $this->client_first;
    }

    public function setClientFirst(?string $client_first): self
    {
        $this->client_first = $client_first;

        return $this;
    }

    /**
     * @return Collection|Work[]
     */
    public function getWorks(): Collection
    {
        return $this->works;
    }

    public function addWork(Work $work): self
    {
        if (!$this->works->contains($work)) {
            $this->works[] = $work;
            $work->setClientId($this);
        }

        return $this;
    }

    public function removeWork(Work $work): self
    {
        if ($this->works->contains($work)) {
            $this->works->removeElement($work);
            // set the owning side to null (unless already changed)
            if ($work->getClientId() === $this) {
                $work->setClientId(null);
            }
        }

        return $this;
    }

    public function getParent(): ?Client
    {
        return $this->parent;
    }

    public function setParent(?Client $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
