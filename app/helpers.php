<?php


    function presentPrice($price)
    {
        $money_format = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        return $money_format->formatCurrency($price / 100, 'USD');
    }

    function setActive($element, $className = 'active')
    {
        return request()->category === $element ? $className : '';
    }

    function productImage($path)
    {
        return $path != null && file_exists('storage/'.$path)
                               ? asset('storage/'.$path) : asset('img/not-found.jpg');
    }

