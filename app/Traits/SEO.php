<?php
/**
 * Created by PhpStorm.
 * User: Sile
 * Date: 4/18/2019
 * Time: 12:26 AM
 */

namespace App\Traits;


use App\Category;
use App\Product;
use Artesaos\SEOTools\Traits\SEOTools;

trait SEO
{
    use SEOTools;

    /**
     * Default SEO optimization for default pages.
     *
     * @param string $pageTitle
     */
    public function seoDefault(string $pageTitle)
    {
        $this->seo()->metatags()
            ->setTitle($pageTitle)
            ->setDescription('Sajt je namenjen kao projekat za specijalistički rad i u demonstrativne svrhe')
            ->setCanonical(url()->current())
            ->setKeywords('E-shop demonstrativni sajt.')
            ->addMeta('author', 'Siniša Bunčić');

        $this->seo()->opengraph()
            ->setTitle($pageTitle)
            ->setDescription('Sajt je namenjen kao projekat za specijalistički rad i u demonstrativne svrhe')
            ->setUrl(url()->current())
            ->setSiteName(config('app.name'))
            ->addProperty('locale', app()->getLocale())
            ->setType('articles');
    }

    /**
     * SEO optimization for home page
     */
    public function seoHome()
    {
        $this->seoDefault('Home');
    }

    /**
     * SEO optimization for product page
     *
     * @param $product
     */
    public function seoProduct(Product $product)
    {
        $this->seo()->metatags()
            ->setTitle($product->title)
            ->setDescription($product->description)
            ->setCanonical($product->getLink())
            ->setKeywords($product->short)
            ->addMeta('author', 'Siniša Bunčić');

        $this->seo()->opengraph()
            ->setTitle($product->title)
            ->setDescription($product->description)
            ->setUrl($product->getLink())
            ->addImage(asset($product->image))
            ->setSiteName(config('app.name'))
            ->addProperty('locale', app()->getLocale())
            ->setType('articles');
    }

    /**
     * Seo optimization for category page.
     *
     * @param Category $category
     */
    public function seoCategory(Category $category)
    {
        $this->seo()->metatags()
            ->setTitle($category->title)
            ->setDescription($category->description)
            ->setCanonical($category->getUrl())
            ->setKeywords($category->keywords)
            ->addMeta('author', 'Siniša Bunčić');

        $this->seo()->opengraph()
            ->setTitle($category->title)
            ->setDescription($category->description)
            ->setUrl($category->getUrl())
            ->addImage(asset($category->image))
            ->setSiteName(config('app.name'))
            ->addProperty('locale', app()->getLocale())
            ->setType('articles');
    }
}