<?php

namespace App\Entity;

use App\Repository\EazyControlRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EazyControlRepository::class)
 */
class EazyControl extends Base
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $defaultLanguage;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extraLanguage = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $defaultCurrency;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extraCurrency;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, cascade={"persist", "remove"})
     */
    private $website;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, cascade={"persist", "remove"})
     */
    private $shop;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, cascade={"persist", "remove"})
     */
    private $blog;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, cascade={"persist", "remove"})
     */
    private $root;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDefaultLanguage(): ?string
    {
        return $this->defaultLanguage;
    }

    public function setDefaultLanguage(?string $defaultLanguage): self
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    public function getExtraLanguage(): ?array
    {
        return $this->extraLanguage;
    }

    public function setExtraLanguage(?array $extraLanguage): self
    {
        $this->extraLanguage = $extraLanguage;

        return $this;
    }

    public function getDefaultCurrency(): ?string
    {
        return $this->defaultCurrency;
    }

    public function setDefaultCurrency(?string $defaultCurrency): self
    {
        $this->defaultCurrency = $defaultCurrency;

        return $this;
    }

    public function getExtraCurrency(): ?string
    {
        return $this->extraCurrency;
    }

    public function setExtraCurrency(?string $extraCurrency): self
    {
        $this->extraCurrency = $extraCurrency;

        return $this;
    }

    public function getWebsite(): ?Page
    {
        return $this->website;
    }

    public function setWebsite(?Page $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getShop(): ?Page
    {
        return $this->shop;
    }

    public function setShop(?Page $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getBlog(): ?Page
    {
        return $this->blog;
    }

    public function setBlog(?Page $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getRoot(): ?Page
    {
        return $this->root;
    }

    public function setRoot(?Page $root): self
    {
        $this->root = $root;

        return $this;
    }
}
