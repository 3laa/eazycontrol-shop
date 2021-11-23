<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
class Base
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $title = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $subtitle = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $text = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $summary = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $html = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $link = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $description = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $keywords = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $isActive = ['default'=>true];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $media = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $viewOptions = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $slug = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $viewsCounter = [];

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?array
    {
        return $this->title;
    }

    public function setTitle(?array $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?array
    {
        return $this->subtitle;
    }

    public function setSubtitle(?array $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getText(): ?array
    {
        return $this->text;
    }

    public function setText(?array $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSummary(): ?array
    {
        return $this->summary;
    }

    public function setSummary(?array $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getHtml(): ?array
    {
        return $this->html;
    }

    public function setHtml(?array $html): self
    {
        $this->html = $html;

        return $this;
    }

    public function getLink(): ?array
    {
        return $this->link;
    }

    public function setLink(?array $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDescription(): ?array
    {
        return $this->description;
    }

    public function setDescription(?array $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function setKeywords(?array $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getIsActive(): ?array
    {
        return $this->isActive;
    }

    public function setIsActive(?array $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function setMedia(?array $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getViewOptions(): ?array
    {
        return $this->viewOptions;
    }

    public function setViewOptions(?array $viewOptions): self
    {
        $this->viewOptions = $viewOptions;

        return $this;
    }

    public function getSlug(): ?array
    {
        return $this->slug;
    }

    public function setSlug(?array $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getViewsCounter(): ?array
    {
        return $this->viewsCounter;
    }

    public function setViewsCounter(?array $viewsCounter): self
    {
        $this->viewsCounter = $viewsCounter;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function updateTimeStamps() {
        $dateTimeNow = new DateTimeImmutable('now');
        $this->setUpdatedAt($dateTimeNow);
        if($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function updateSlug() {
        $slugify = new Slugify();
        $slug = [];
        $slug['name'] = $slugify->slugify($this->getName());
        if (is_array($this->getTitle()) || is_object($this->getTitle()))
        {
            foreach($this->getTitle() as $key=>$value) {
                if($value) {
                    $slug[$key] = $slugify->slugify($value);
                } else {
                    $slug[$key] = '';
                }
            }
            $this->setSlug($slug);
        }
    }
}
