<?php

use Merophp\PhpTemplateViewPlugin\PhpTemplateView;
use Merophp\PhpTemplateViewPlugin\PhpTemplateViewConfiguration;
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
        self::$instance->assign('testVar', 'Foo');
        $this->assertEquals(['testVar' => 'Foo'], self::$instance->getArguments());
    }

    public function testAssignGlobalArgument()
    {
        self::$instance->assignGlobalArgument('testVar', 'Foo2');
        $this->assertEquals(['testVar' => 'Foo2'], self::$instance->getGlobalArguments());
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
