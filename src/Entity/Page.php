<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page extends Base
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isToggle = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ableToDelete = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ableToEdit = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ableToAdd = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ableToChangeActive = true;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $shortcut = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $layout;

    /**
     * @ORM\ManyToOne(targetEntity=Page::class, inversedBy="pages")
     */
    private $page;

    /**
     * @ORM\OneToMany(targetEntity=Page::class, mappedBy="page")
     */
    private $pages;

    /**
     * @ORM\OneToMany(targetEntity=Section::class, mappedBy="page")
     * @ORM\OrderBy({"sort" = "ASC"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $sections;


    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->sections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsToggle(): ?bool
    {
        return $this->isToggle;
    }

    public function setIsToggle(?bool $isToggle): self
    {
        $this->isToggle = $isToggle;

        return $this;
    }

    public function getAbleToDelete(): ?bool
    {
        return $this->ableToDelete;
    }

    public function setAbleToDelete(?bool $ableToDelete): self
    {
        $this->ableToDelete = $ableToDelete;

        return $this;
    }

    public function getAbleToEdit(): ?bool
    {
        return $this->ableToEdit;
    }

    public function setAbleToEdit(?bool $ableToEdit): self
    {
        $this->ableToEdit = $ableToEdit;

        return $this;
    }

    public function getAbleToAdd(): ?bool
    {
        return $this->ableToAdd;
    }

    public function setAbleToAdd(?bool $ableToAdd): self
    {
        $this->ableToAdd = $ableToAdd;

        return $this;
    }

    public function getAbleToChangeActive(): ?bool
    {
        return $this->ableToChangeActive;
    }

    public function setAbleToChangeActive(?bool $ableToChangeActive): self
    {
        $this->ableToChangeActive = $ableToChangeActive;

        return $this;
    }

    public function getShortcut(): ?array
    {
        return $this->shortcut;
    }

    public function setShortcut(?array $shortcut): self
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPage(): ?self
    {
        return $this->page;
    }

    public function setPage(?self $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(self $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setPage($this);
        }

        return $this;
    }

    public function removePage(self $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getPage() === $this) {
                $page->setPage(null);
            }
        }

        return $this;
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function setLayout(?string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setPage($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getPage() === $this) {
                $section->setPage(null);
            }
        }

        return $this;
    }
}
