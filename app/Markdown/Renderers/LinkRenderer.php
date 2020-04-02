<?php

namespace RyanChandler\Markdown\Renderers;

use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Inline\Renderer\LinkRenderer as BaseLinkRenderer;
use League\CommonMark\Util\ConfigurationInterface;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\ElementRendererInterface;

class LinkRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    /**
     * @var \League\CommonMark\Inline\Renderer\LinkRenderer
     */
    protected $baseLinkRenderer;

    public function __construct()
    {
        $this->baseLinkRenderer = new BaseLinkRenderer;
    }

    /**
     * @param Link                     $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        $inline->data['attributes']['target'] = '_blank';
        
        $this->baseLinkRenderer->setConfiguration($this->config);
        
        return $this->baseLinkRenderer->render($inline, $htmlRenderer);
    }

    /**
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}