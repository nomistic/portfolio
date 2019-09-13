<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 */
class Work
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text",length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="works")
     */
    private $client_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $pub_url;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $priv_url;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ghost_ind;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="works")
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $net_pay;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $hours;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hourly;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Format", inversedBy="works")
     */
    private $format;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_submitted;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Platform", inversedBy="works")
     */
    private $platform;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $work_type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject", inversedBy="work")
     *  @ORM\JoinTable(name="subject_work")
     */
    private $subjects;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
    }



//getters and setters
    public function __toString(){
        // to show the name of the Category in the select
        return $this->title;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getClientId(): ?Client
    {
        return $this->client_id;
    }

    public function setClientId(?Client $client_id): self
    {
        $this->client_id = $client_id;

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

    public function getPubUrl(): ?string
    {
        return $this->pub_url;
    }

    public function setPubUrl(?string $pub_url): self
    {
        $this->pub_url = $pub_url;

        return $this;
    }

    public function getPrivUrl(): ?string
    {
        return $this->priv_url;
    }

    public function setPrivUrl(?string $priv_url): self
    {
        $this->priv_url = $priv_url;

        return $this;
    }

    public function getGhostInd(): ?bool
    {
        return $this->ghost_ind;
    }

    public function setGhostInd(bool $ghost_ind): self
    {
        $this->ghost_ind = $ghost_ind;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNetPay(): ?string
    {
        return $this->net_pay;
    }

    public function setNetPay(?string $net_pay): self
    {
        $this->net_pay = $net_pay;

        return $this;
    }

    public function getHours(): ?string
    {
        return $this->hours;
    }

    public function setHours(?string $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getHourly(): ?bool
    {
        return $this->hourly;
    }

    public function setHourly(bool $hourly): self
    {
        $this->hourly = $hourly;

        return $this;
    }

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(?Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getDateSubmitted(): ?\DateTimeInterface
    {
        return $this->date_submitted;
    }

    public function setDateSubmitted(?\DateTimeInterface $date_submitted): self
    {
        $this->date_submitted = $date_submitted;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->date_published;
    }

    public function setDatePublished(?\DateTimeInterface $date_published): self
    {
        $this->date_published = $date_published;

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getWorkType(): ?string
    {
        return $this->work_type;
    }

    public function setWorkType(?string $work_type): self
    {
        $this->work_type = $work_type;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->addWork($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            $subject->removeWork($this);
        }

        return $this;
    }




}
