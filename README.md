# DRAFT

# Introduction
PHP template view plugin for merophp/view-engine.

(!) Be aware of security problems if you don't escape your variables in templates.

## Installation

Via composer:

<code>
composer require merophp/php-template-view
</code>

## Basic Usage

<pre><code>require_once 'vendor/autoload.php';

use Merophp\PhpTemplateViewPlugin\PhpTemplateView;

use Merophp\ViewEngine\ViewEngine;
use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use Merophp\ViewEngine\TemplateArgument\Argument;
use Merophp\ViewEngine\TemplateArgument\SharedArgument;

$collection = new ViewPluginCollection();
$collection->add(
    new ViewPlugin(PhpTemplateView::class),
]);

$provider = new ViewPluginProvider($collection);

$viewEngine = new ViewEngine($provider);

$view = $viewEngine->initializeView();
$view->assignTemplateArguments(
    new Argument('name', 'Tom'),
    new SharedArgument('name', 'Tom') //This argument is available in the template and all of its partials
);
$view->template('viewPackage.hello');
echo $viewEngine->renderView($view);
</code></pre>