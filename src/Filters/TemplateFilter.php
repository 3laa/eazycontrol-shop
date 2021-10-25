<?php

namespace App\Filters;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TemplateFilter extends AbstractExtension
{
    private PageRepository $pageRepository;
    private UrlGeneratorInterface $generator;

    /**
     * @param PageRepository $pageRepository
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(PageRepository $pageRepository, UrlGeneratorInterface $generator)
    {
        $this->pageRepository = $pageRepository;
        $this->generator = $generator;
    }


    public function getFilters(): array
    {
        return [
            new TwigFilter('getPageLink', [$this, 'getPageLink']),
            new TwigFilter('mediaLink', [$this, 'mediaLink']),
        ];
    }

    public function mediaLink(array $media): array
    {
        $link['class'] = '-image';
        $link['url'] = $media['image'];

        if(array_key_exists('youtube', $media)) {
            if($media['youtube']) {
                $link['class'] = '-iframe';
                $link['url'] = "https://www.youtube-nocookie.com/embed/".$media['youtube'];
            }
        }

        return $link;
    }

    public function getPageLink(Page $page, string $local): array
    {
        $result['target'] = '_self';
        if(array_key_exists($local, $page->getSlug()))
        {
            $result['link'] = $this->generator->generate('frontend_page_slug', ['page'=>$page->getId(), 'slug'=>$page->getSlug()[$local]]);
        }
        else
        {
            $result['link'] = $this->generator->generate('frontend_page_id', ['page'=>$page->getId()]);
        }

        $pageId = $page->getShortcut()['blog'];
        if($page->getShortcut()['website']!=null)
        {
            $pageId = $page->getShortcut()['website'];
        }
        else if($page->getShortcut()['shop']!=null)
        {
            $pageId = $page->getShortcut()['shop'];
        }

        if($pageId)
        {
            $shortcutPage = $this->pageRepository->findOneBy(['id'=>$pageId]);
            if($shortcutPage)
            {
                if(array_key_exists($local, $shortcutPage->getSlug()))
                {
                    $result['link'] = $this->generator->generate('frontend_page_slug', ['page'=>$shortcutPage->getId(), 'slug'=>$shortcutPage->getSlug()[$local]]);
                }
                else
                {
                    $result['link'] = $this->generator->generate('frontend_page_id', ['page'=>$shortcutPage->getId()]);
                }
            }
        }

        if(array_key_exists($local, $page->getLink()))
        {
            if($page->getLink()[$local])
            {
                if($page->getLink()[$local]['url'])
                {
                    $result['link'] = $page->getLink()[$local]['url'];
                    $result['target'] = $page->getLink()[$local]['target'];
                }
            }
        }

        return $result;

    }
}
