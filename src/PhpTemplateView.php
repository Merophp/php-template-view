<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin;

use Exception;
use Throwable;

use Merophp\ViewEngine\ViewInterface;

use Merophp\PhpTemplateViewPlugin\ViewPart\{Layout, Partial, Renderer\ViewPartRenderer, Template};

use Merophp\PhpTemplateViewPlugin\Link\Collection\LinkCollection;
use Merophp\PhpTemplateViewPlugin\Link\Link;
use Merophp\PhpTemplateViewPlugin\Link\Serializer\LinkSerializerLinkTag;

use Merophp\PhpTemplateViewPlugin\Script\Collection\ScriptLinkCollection;
use Merophp\PhpTemplateViewPlugin\Script\ScriptLink;
use Merophp\PhpTemplateViewPlugin\Script\Serializer\ScriptLinkSerializer;

/**
 * @author Robert Becker
 */
class PhpTemplateView implements ViewInterface
{

	/**
	 * @var ?Template
	 */
	private ?Template $template = null;

	/**
	 * @var ?Layout
	 */
	private ?Layout $layout = null;

	/**
	 * @var array
	 */
	private array $arguments = [];

    /**
     * @var array
     */
    private array $sharedArguments = [];

	/**
	 * @var array
	 */
	private static array $defaultArguments = [];

	/**
	 * @var LinkCollection
	 */
	private LinkCollection $cssFiles;

	/**
	 * @var ScriptLinkCollection
	 */
	private ScriptLinkCollection $jsFiles;

    protected ?PhpTemplateViewConfiguration $configuration = null;

    private TemplateViewRenderer $templateViewRenderer;

    private LinkSerializerLinkTag $linkSerializer;

    private ScriptLinkSerializer $scriptLinkSerializer;

    private ViewPartRenderer $viewPartRenderer;

    /**
     * @param ?PhpTemplateViewConfiguration $configuration
     */
    public function __construct(PhpTemplateViewConfiguration $configuration = null)
    {
        $this->configuration = $configuration;

        $this->templateViewRenderer = new TemplateViewRenderer($configuration);
        $this->viewPartRenderer = new ViewPartRenderer($configuration);

        $this->scriptLinkSerializer = new ScriptLinkSerializer();
        $this->linkSerializer = new LinkSerializerLinkTag();

        $this->cssFiles = new LinkCollection();
        $this->jsFiles = new ScriptLinkCollection();
    }

    /**
     * @return array
     */
    public static function getDefaultArguments(): array
    {
        return self::$defaultArguments;
    }


    /**
     * Define the template
     *
     * @api
     * @param string $ident
     * @param array $variables
     * @throws Exception
     */
    public function template(string $ident, array $variables = [])
    {
        $this->createTemplate($ident, $variables);
    }

    /**
     * Define the layout
     *
     * @api
     * @param string $ident
     * @param array $variables
     * @throws Exception
     */
    public function layout(string $ident, array $variables = [])
    {
        $this->createLayout($ident, $variables);
    }

    /**
     * Assign default arguments for all templates and layouts
     *
     * @param string $key
     * @param $value
     * @throws Exception
     * @api
     */
	public static function assignDefaultArgument(string $key, $value)
    {
		self::$defaultArguments[$key] = $value;
	}

    /**
     * Assign shared arguments for template and related partials
     *
     * @param string $key
     * @param $value
     * @throws Exception
     * @api
     */
	public function assignSharedArgument(string $key, $value)
    {
		$this->sharedArguments[$key] = $value;
	}

    /**
     * @return string
     * @throws Exception
     */
	public function render(): string
    {
	    return $this->templateViewRenderer->render($this);
	}

    /**
     * @param string $identifier
     * @param TemplateService $templateService
     * @param array $arguments
     * @return string
     */
    public function renderPartial(string $identifier, TemplateService $templateService, array $arguments = []): string
    {
        try{
            list($package, $name) = TemplateViewUtility::splitIdentifier($identifier);

            return $this->viewPartRenderer->render(
                new Partial($package, $name, $arguments),
                $templateService,
                array_merge(
                    static::getDefaultArguments(),
                    $this->getSharedArguments()
                )
            );
        }
        catch(Throwable $e){
            return sprintf(
                'Error in partial "%s": %s',
                $identifier,
                $e->getMessage()
            );
        }

    }

    /**
     * @param Template $template
     */
	public function setTemplate(Template $template)
    {
		$this->template = $template;
	}

    /**
     * @param Layout $layout
     */
	public function setLayout(Layout $layout){
		$this->layout = $layout;
	}

    /**
     * @api
     * @param string $key
     * @param $value
     */
	public function assign(string $key, $value)
    {
		$this->arguments[$key] = $value;
	}

    /**
     * @param string $src
     * @param array $options
     * @param string $destination
     * @api
     */
	public function includeJsFile(string $src, array $options = [], string $destination = '')
    {
		$newScript = new ScriptLink($this->addHashToSrc($src), $options, $destination);
		if(!$this->jsFiles->has($newScript)){
            $this->jsFiles->add($newScript);
        }
	}

    /**
     * @param string $destination
     * @return string
     */
	public function renderIncludedJsFiles(string $destination = ''): string
    {
        $string = '';
        foreach($this->jsFiles->getScriptLinksByDestination($destination) as $scriptLink){
            $string .= $this->scriptLinkSerializer->serialize($scriptLink);
        }
        return $string;
    }


    /**
     * @param string $src
     * @param array $options
     * @api
     */
	public function includeCssFile(string $src, array $options = [])
    {
        $rel = $options['rel'] ?? 'Stylesheet';
        $newStylesheet = new Link($this->addHashToSrc($src), explode(' ', $rel), $options);
        if(!$this->cssFiles->has($newStylesheet)){
            $this->cssFiles->add($newStylesheet);
        }
	}

    /**
     * @return string
     */
    public function renderIncludedCssFiles(): string
    {
        $string = '';
        foreach($this->cssFiles as $link){
            $string .= $this->linkSerializer->serialize($link);
        }
        return $string;
    }

    /**
     * @param string $src
     * @return string
     */
	private function addHashToSrc(string $src): string
    {
	    if($this->configuration && $this->configuration->getResourcePostfix()){
            if(strpos('?', $src) > -1) $src .= '&h=';
            else $src .= '?h=';

            $src .= $this->configuration->getResourcePostfix();
        }
        return $src;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->configuration->getContentType() ?? 'text/html;charset=utf-8';
    }

    /**
     * Define the template
     *
     * @param string $ident
     * @param array $variables
     * @throws Exception
     */
    private function createTemplate(string $ident, array $variables = [])
    {
        list($package, $name) = TemplateViewUtility::splitIdentifier($ident);

        $this->setTemplate(new Template($package, $name, $variables));
    }

    /**
     * Define the layout
     *
     * @param string $ident
     * @param array $variables
     * @throws Exception
     */
    private function createLayout(string $ident, array $variables = [])
    {
        list($package, $name) = TemplateViewUtility::splitIdentifier($ident);

        $this->setLayout(new Layout($package, $name, $variables));
    }

    /**
     * @return array
     */
    public function getSharedArguments(): array
    {
        return $this->sharedArguments;
    }

    /**
     * @return Layout|null
     */
    public function getLayout(): ?Layout
    {
        return $this->layout;
    }

    /**
     * @return Template|null
     */
    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
