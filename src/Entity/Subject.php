<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Work", mappedBy="subjects")
     */
    private $work;

    public function __construct()
    {
        $this->work = new ArrayCollection();
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
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

    /**
     * @return Collection|Work[]
     */
    public function getWork(): Collection
    {
        return $this->work;
    }

    public function addWork(Work $work): self
    {
        if (!$this->work->contains($work)) {
            $this->work[] = $work;
        }

        return $this;
    }

    public function removeWork(Work $work): self
    {
        if ($this->work->contains($work)) {
            $this->work->removeElement($work);
        }

        return $this;
    }
}
