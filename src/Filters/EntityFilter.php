<?php

namespace App\Filters;

use App\Entity\Content;
use App\Entity\Page;
use App\Entity\Section;
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
            new TwigFilter('activeSections', [$this, 'activeSections']),
            new TwigFilter('activeContents', [$this, 'activeContents']),
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

    /**
     * @param $sections
     * @param string $locale
     * @return Section[]|Collection
     */
    public function activeSections($sections, string $locale) {
        foreach ($sections as $key => $section) {
            if(array_key_exists($locale, $section->getIsActive())) {
                if(!$section->getIsActive()[$locale]) {
                    unset($sections[$key]);
                }
            } else {
                if(is_array($section) ) unset($section[$key]);
            }
        }
        return $sections;
    }

    /**
     * @param Collection|Content[] $contents
     * @param string $locale
     * @return Content[]|Collection
     */
    public function activeContents($contents, string $locale) {
        foreach ($contents as $key => $content) {
            if(array_key_exists($locale, $content->getIsActive())) {
                if(!$content->getIsActive()[$locale]) {
                    unset($contents[$key]);
                }
            } else {
                unset($contents[$key]);
            }
        }
        return $contents;
    }
}
