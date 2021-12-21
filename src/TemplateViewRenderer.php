<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin;

use Exception;
use Merophp\PhpTemplateViewPlugin\ViewPart\Renderer\ViewPartRenderer;

/**
 * @author Robert Becker
 */
class TemplateViewRenderer
{

    private ViewPartRenderer $viewPartRenderer;

    /**
     * @param ?PhpTemplateViewConfiguration $configuration
     */
    public function __construct(PhpTemplateViewConfiguration $configuration = null)
    {
        $this->viewPartRenderer = new ViewPartRenderer($configuration);
    }

    /**
     * @param PhpTemplateView $phpTemplateView
     * @return string
     * @throws Exception
     */
    public function render(PhpTemplateView $phpTemplateView): string
    {

        $templateService = new TemplateService($phpTemplateView);

        $renderedTemplate = $this->viewPartRenderer->render(
            $phpTemplateView->getTemplate(),
            $templateService,
            array_merge(
                $phpTemplateView::getDefaultArguments(),
                $phpTemplateView->getSharedArguments(),
                $phpTemplateView->getArguments()
            ),
        );

        if($phpTemplateView->getLayout()){
            $MARKER['content'] = $renderedTemplate;

            return $this->viewPartRenderer->render(
                $phpTemplateView->getLayout(),
                $templateService,
                array_merge(
                    $phpTemplateView::getDefaultArguments(),
                    $phpTemplateView->getSharedArguments(),
                    [
                        'view' => [
                            'template' => [
                                'name' => $phpTemplateView->getTemplate()->getName(),
                                'package' => $phpTemplateView->getTemplate()->getPackage()
                            ]
                        ]
                    ]
                ),
                $MARKER
            );
        }
        else{
            return $renderedTemplate;
        }
    }
}
