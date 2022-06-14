<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart\Renderer;

use Exception;
use Merophp\PhpTemplateViewPlugin\PhpTemplateViewConfiguration;
use Merophp\PhpTemplateViewPlugin\TemplateArgument\{
    Argument, GlobalArgument, SharedArgument
};
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
     * @param Argument[] $assignedArguments
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

        $argumentsAsMap = $this->convertArgumentsToMap(array_merge($viewPart->getArguments(), $assignedArguments));

        $renderFuntion = function(string $file, array $argumentsAsMap, TemplateService $templateService, array $marker=[]){
            extract($argumentsAsMap);
            ob_start();
            require($file);
            $result=ob_get_contents();
            ob_end_clean();
            return $result;
        };

        return $renderFuntion($file, $argumentsAsMap, $templateService, $marker);
    }

    /**
     * @param Argument[] $arguments
     * @return array
     */
    private function convertArgumentsToMap(array $arguments): array
    {
        $argsAsMap = [];

        $globalArguments = array_filter($arguments, function($arg){
            return get_class($arg) === GlobalArgument::class;
        });
        foreach($globalArguments as $arg){
            $argsAsMap[$arg->getName()] = $arg->getValue();
        }

        $sharedArguments = array_filter($arguments, function($arg){
            return get_class($arg) === SharedArgument::class;
        });
        foreach($sharedArguments as $arg){
            $argsAsMap[$arg->getName()] = $arg->getValue();
        }

        $localArguments = array_filter($arguments, function($arg){
            return get_class($arg) === Argument::class;
        });
        foreach($localArguments as $arg){
            $argsAsMap[$arg->getName()] = $arg->getValue();
        }
        return $argsAsMap;
    }
}
