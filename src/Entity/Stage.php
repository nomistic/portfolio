<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Work", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $work_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $stage_no;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_due;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $budget_hours;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $budget_setrate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $completed_hours;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_updated;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkId(): ?Work
    {
        return $this->work_id;
    }

    public function setWorkId(?Work $work_id): self
    {
        $this->work_id = $work_id;

        return $this;
    }

    public function getStageNo(): ?int
    {
        return $this->stage_no;
    }

    public function setStageNo(int $stage_no): self
    {
        $this->stage_no = $stage_no;

        return $this;
    }

    public function getDateDue(): ?\DateTimeInterface
    {
        return $this->date_due;
    }

    public function setDateDue(?\DateTimeInterface $date_due): self
    {
        $this->date_due = $date_due;

        return $this;
    }

    public function getBudgetHours(): ?string
    {
        return $this->budget_hours;
    }

    public function setBudgetHours(?string $budget_hours): self
    {
        $this->budget_hours = $budget_hours;

        return $this;
    }

    public function getBudgetSetrate(): ?int
    {
        return $this->budget_setrate;
    }

    public function setBudgetSetrate(?int $budget_setrate): self
    {
        $this->budget_setrate = $budget_setrate;

        return $this;
    }

    public function getCompletedHours(): ?string
    {
        return $this->completed_hours;
    }

    public function setCompletedHours(?string $completed_hours): self
    {
        $this->completed_hours = $completed_hours;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->last_updated;
    }

    public function setLastUpdated(\DateTimeInterface $last_updated): self
    {
        $this->last_updated = $last_updated;

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

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }
}
