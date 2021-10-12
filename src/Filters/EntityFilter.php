<?php

namespace App\Filters;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\Collection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EntityFilter extends AbstractExtension
{
    /**
     * @var PageRepository
     */
    private PageRepository $pageRepository;

    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }


    public function getFilters(): array
    {
        return [
            new TwigFilter('activePages', [$this, 'activePages']),
        ];
    }

    /**
     * @param Collection|Page[] $pages
     * @param string $locale
     * @return Collection|Page[]
     */
    public function activePages($pages, string $locale)
    {
        foreach ($pages as $key => $page) {
            if(array_key_exists($locale, $page->getIsActive())) {
                if(!$page->getIsActive()[$locale]) {
                    unset($pages[$key]);
                }
            } else {
                unset($pages[$key]);
            }
        }
        return $pages;
    }
}
