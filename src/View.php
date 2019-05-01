<?php

namespace gamringer\PHPREST;

class View
{
    protected $template;
    protected $data;
    protected $blocks;

    protected $parent;
    protected $parentData;

    protected $urlRoot;
    protected $urlRootScheme;

    private $currentBlock = null;

    public function __construct($template, $data = [], $blocks = [])
    {
        if (!is_readable($template)) {
            throw new \Exception('Template is unreadable');
        }

        $this->template = $template;
        $this->data = $data;
        $this->blocks = $blocks;
    }

    public function addData($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    public function __toString(): string
    {
        ob_start();

        extract($this->data);

        include $this->template;

        $content = ob_get_clean();
        if ($content === false) {
            return '';
        }

        if (isset($this->parent)) {
            $parentView = new View($this->parent, $this->parentData, $this->blocks);
            $parentView->setURLRoot($this->urlRoot);

            return $parentView->__toString();
        }

        return $content;
    }

    public function getBlockObject($name)
    {
        if (!array_key_exists($name, $this->blocks)) {
            return;
        }

        return $this->blocks[$name];
    }

    public function getBlock($name)
    {
        echo $this->getBlockObject($name);
    }

    public function defineBlock($name, View $blockView)
    {
        if (array_key_exists($name, $this->blocks)) {
            return;
        }

        $this->blocks[$name] = $blockView;
    }

    public function startBlock($name, $data = [])
    {
        ob_start();

        if ($this->currentBlock !== null) {
            return;
        }

        if (array_key_exists($name, $this->blocks) && $this->blocks[$name] instanceof View) {
            $this->blocks[$name]->addData($data);
        }

        $this->currentBlock = $name;
    }

    public function endBlock()
    {
        if (!array_key_exists($this->currentBlock, $this->blocks)) {
            $this->blocks[$this->currentBlock] = ob_get_contents();
        }

        ob_end_clean();

        echo $this->blocks[$this->currentBlock];

        $this->currentBlock = null;
    }

    public function extend($template, $data = [])
    {
        if (!is_readable($template)) {
            throw new \Exception('Template is unreadable');
        }

        $this->parent = $template;
        $this->parentData = $data;
    }

    public function setURLRoot($url)
    {
        $this->urlRoot = $url;
        $this->urlRootScheme = parse_url($url, \PHP_URL_SCHEME);
    }

    protected function linkTo($url, $queryData = [])
    {
        if (substr($url, 0, 2) == '//') {
            $url = $this->urlRootScheme . ':' . $url;
        } elseif (substr($url, 0, 1) == '/') {
            $url = $this->urlRoot . $url;
        }

        if (!empty($queryData)) {
            $url .= '?' . http_build_query($queryData);
        }

        return $url;
    }

    const ESCAPE_HTML = 'html';
    const ESCAPE_QUERY = 'query';

    protected function escape($value, $mode = 'html')
    {
        if ($mode == self::ESCAPE_HTML) {
            return htmlspecialchars($value);
        }

        return $value;
    }
}
