<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 19.10.18
 * Time: 14:37
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

// Из-за того что мы расширились от
class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter('price', [$this, 'priceFilter'])];
    }

    public function priceFilter($number)
    {
        return '$'. number_format($number, 2, '.', ' ');
    }
}