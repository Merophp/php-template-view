<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin;

use Exception;

/**
 * Proxy class for PhpTemplateView to pass down for templates, layouts and partials
 * @author Robert Becker
 */
class TemplateService
{

	/**
	 * @var PhpTemplateView
	 */
	protected PhpTemplateView $view;

    /**
     * @param PhpTemplateView $view
     */
	public function __construct(PhpTemplateView $view)
    {
		$this->view = $view;
	}

    /**
     * @param string $identifier
     * @param array $arguments
     * @return string
     */
	public function partial(string $identifier, array $arguments = [])
    {
        return $this->view->renderPartial(
            $identifier,
            $this,
            $arguments
        );
	}

    /**
     * @param string $src
     * @param array $options
     */
	public function includeBottomJsFile(string $src, array $options = [])
    {
        $this->view->includeJsFile($src, $options, 'bottom');
    }

    /**
     * @return string
     */
    public function renderIncludedBottomJsFiles(): string
    {
        return $this->view->renderIncludedJsFiles('bottom');
    }

    /**
     * @param string $methodName
     * @param array $arguments
     * @return false|mixed|void
     */
    public function __call(string $methodName, array $arguments = [])
    {
        if(!in_array($methodName, [
            'includeJsFile',
            'renderIncludedJsFiles',
            'includeCssFile',
            'renderIncludedCssFiles'
        ])) return;

        return call_user_func_array([$this->view, $methodName], $arguments);
    }
}
