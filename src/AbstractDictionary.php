<?php


namespace EasySwoole\I18N;


abstract class AbstractDictionary
{
    function getDictionary():array
    {
        $oClass = new \ReflectionClass(static::class);
        return $oClass->getConstants();
    }
}