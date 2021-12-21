<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart\Renderer;

use Exception;
use Merophp\PhpTemplateViewPlugin\PhpTemplateViewConfiguration;
use Merophp\PhpTemplateViewPlugin\TemplateService;
use Merophp\PhpTemplateViewPlugin\ViewPart\ViewPartInterface;

class ViewPartRenderer
{

    /**
     * @var ?PhpTemplateViewConfiguration
     */
    protected ?PhpTemplateViewConfiguration $configuration = null;

    /**
     * @param ?PhpTemplateViewConfiguration $configuration
     */
    public function __construct(PhpTemplateViewConfiguration $configuration = null)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param ViewPartInterface $viewPart
     * @param TemplateService $templateService
     * @param array $assignedArguments
     * @param array $marker
     * @return false|string
     * @throws Exception
     */
    public function render(ViewPartInterface $viewPart, TemplateService $templateService, array $assignedArguments = [], array $marker=[])
    {
        if($this->configuration)
            $file = $this->configuration->getViewDir().'/'.$viewPart->getFilePath();
        else $file = $viewPart->getFilePath();

        if(!is_file($file))
            throw new Exception(sprintf(
                'File (%s) for view not found!',
                $file
            ));

        $allArguments = array_merge(
            $assignedArguments,
            $viewPart->getLocalVariables()
        );

        $renderFuntion = function(string $file, array $arguments, TemplateService $templateService, array $marker=[]){
            extract($arguments);
            ob_start();
            require($file);
            $result=ob_get_contents();
            ob_end_clean();
            return $result;
        };

        return $renderFuntion($file, $allArguments, $templateService, $marker);
    }
}
