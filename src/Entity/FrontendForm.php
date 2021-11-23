<?php

namespace App\Entity;

use App\Repository\FrontendFormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FrontendFormRepository::class)
 */
class FrontendForm extends Base
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $frontend;

    /**
     * @ORM\OneToMany(targetEntity=Section::class, mappedBy="frontendForm")
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sendTo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sendFrom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $finisher;

    public function __construct()
    {
        $this->section = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFrontend(): ?string
    {
        return $this->frontend;
    }

    public function setFrontend(string $frontend): self
    {
        $this->frontend = $frontend;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSection(): Collection
    {
        return $this->section;
    }

    public function addSection(Section $section): self
    {
        if (!$this->section->contains($section)) {
            $this->section[] = $section;
            $section->setFrontendForm($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->section->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getFrontendForm() === $this) {
                $section->setFrontendForm(null);
            }
        }

        return $this;
    }

    public function getSendTo(): ?string
    {
        return $this->sendTo;
    }

    public function setSendTo(string $sendTo): self
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    public function getSendFrom(): ?string
    {
        return $this->sendFrom;
    }

    public function setSendFrom(string $sendFrom): self
    {
        $this->sendFrom = $sendFrom;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getFinisher(): ?string
    {
        return $this->finisher;
    }

    public function setFinisher(?string $finisher): self
    {
        $this->finisher = $finisher;

        return $this;
    }


}
