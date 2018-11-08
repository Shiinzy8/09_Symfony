<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 19.10.18
 * Time: 14:37
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

// Из-за того что мы расширились от AbstractExtension у нас работает автоматическое создание сервиса из этого класса
// он уже является сервисом что можно проверить через команду
// php bin/console debug:container 'App\Twig\AppExtension'

// что б можно было прокидывать глобальные переменные в шаблоны нам надо расширить еще класс GlobalInterface
// потом через настройку сервиса в services.yaml пробросить в его аргументы все что нам надо
// добавить данный параметр в конструктор класса и реализовать метод getGlobals
class AppExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var string
     */
    private $locale;

    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    public function getFilters()
    {
        return [new TwigFilter('price', [$this, 'priceFilter'])];
    }

    public function priceFilter($number)
    {
        return '$'. number_format($number, 2, '.', ' ');
    }

    public function getGlobals()
    {
        return [
            'locale' => $this->locale,
        ];
    }
}