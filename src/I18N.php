<?php


namespace EasySwoole\I18N;


use EasySwoole\Component\Singleton;
use EasySwoole\I18N\Exception\Exception;
use Swoole\Coroutine;

class I18N
{
    use Singleton;

    protected $context = [];
    protected $dictionaryList = [];
    /** @var  AbstractDictionary */
    protected $default = null;

    function addLanguage(AbstractDictionary $abstractDictionary, string $lang):I18N
    {
        $this->dictionaryList[$lang] = $abstractDictionary;
        return $this;
    }

    function setDefaultLanguage(string $lan):I18N
    {
        $this->default = $lan;
        return $this;
    }

    function setLanguage(string $lan):I18N
    {
        $this->context[$this->cid()] = $lan;
        return $this;
    }

    function getLanguage():?string
    {
        $cid = $this->cid();
        if(isset($this->context[$cid])){
            return $this->context[$cid];
        }
        if($this->default){
            $this->context[$cid] = $this->default;
            return $this->context[$cid];
        }
        return null;
    }

    private function cid():int
    {
        $cid = Coroutine::getCid();
        if(!isset($this->context[$cid]) && $cid > 0){
            Coroutine::defer(function ()use($cid){
                unset($this->context[$cid]);
            });
        }
        return $cid;
    }

    function translate(string $key)
    {
        $lan = $this->getLanguage();
        if(empty($lan)){
            throw new Exception("not default language set");
        }
        if(isset($this->dictionaryList[$lan])){
            $dict = get_class($this->dictionaryList[$lan]);
            return constant("{$dict}::{$key}");
        }else{
            throw new Exception("not dictionary for {$lan} language");
        }
    }

    function sprintf(string $tpl,...$args)
    {
        $data = [];
        foreach ($args as $arg){
            $data[] = $this->translate($arg);
        }
        return sprintf($tpl,...$data);
    }
}