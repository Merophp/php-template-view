<?php

use Merophp\PhpTemplateViewPlugin\PhpTemplateView;
use Merophp\PhpTemplateViewPlugin\PhpTemplateViewConfiguration;
use Merophp\PhpTemplateViewPlugin\TemplateArgument\Argument;
use Merophp\PhpTemplateViewPlugin\TemplateArgument\GlobalArgument;
use Merophp\PhpTemplateViewPlugin\TemplateArgument\SharedArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers PhpTemplateView
 */
class PhpTemplateViewTest extends TestCase
{
    private static $instance = null;

    public static function setUpBeforeClass(): void
    {
        $config = new PhpTemplateViewConfiguration();
        $config->setViewDir(dirname(__DIR__).'/testData/views/');
        $config->setResourcePostfix('1234');
        self::$instance = new PhpTemplateView($config);
    }

    public function testTemplate()
    {
        self::$instance->template('test-package.test-template');
        $this->assertNotNull(self::$instance->getTemplate());
    }

    public function testLayout()
    {
        self::$instance->layout('test-package.test-layout');
        $this->assertNotNull(self::$instance->getLayout());
    }

    public function testAssign()
    {
        $clonedInstance = clone self::$instance;
        $clonedInstance->assign('testVar', 'Foo');
        $this->assertEquals(1, count($clonedInstance->getArguments()));
    }

    public function testAssignGlobalArgument()
    {
        $clonedInstance = clone self::$instance;
        $clonedInstance->assignDefaultArgument('testVar', 'Foo2');
        $this->assertEquals(1, count($clonedInstance->getDefaultArguments()));
    }

    public function testAssignTemplateArguments()
    {
        $clonedInstance = clone self::$instance;
        $clonedInstance->assignTemplateArguments(
            new Argument('test1','Bar1'),
            new SharedArgument('test2','Bar2'),
            new GlobalArgument('test3','Bar3')
        );
        $this->assertEquals(2, count($clonedInstance->getArguments()));
        $this->assertEquals(2, count($clonedInstance::getDefaultArguments()));
    }

    public function testIncludeJsFile()
    {
        self::$instance->includeJsFile('public/js/main.js', ['async' => '']);
        $this->assertEquals('<script src="public/js/main.js?h=1234" async=""  ></script>', self::$instance->renderIncludedJsFiles());
    }

    public function testIncludeCssFile()
    {
        self::$instance->includeCssFile('public/css/main.css', ['media' => 'screen']);

        $this->assertEquals('<link href="public/css/main.css?h=1234" rel="Stylesheet" media="screen" />', self::$instance->renderIncludedCssFiles());
    }

    public function testRender()
    {
        $this->assertEquals('Hello Willy', self::$instance->render());
    }
}
