<?php
namespace Merophp\PhpTemplateViewPlugin\Script\Serializer;

use Merophp\PhpTemplateViewPlugin\Script\ScriptLinkInterface;

/**
 * Generates HTML for JS resource including.
 * @author Robert Becker
 */
class ScriptLinkSerializer
{

    /**
     * @param ScriptLinkInterface $link
     * @return string
     */
    public function serialize(ScriptLinkInterface $link): string
    {
        $template = '<script src="%s" %s ></script>';

        $attributes = '';
        foreach($link->getAttributes() as $key => $value){
            if( $value === false ) continue;

            if( $value === true ) $value = '';
            else $value = htmlspecialchars((string) $value);

            $attributes .= htmlspecialchars($key).'="'.$value.'" ';
        }

        return sprintf(
            $template,
            htmlspecialchars($link->getSrc()),
            $attributes
        );
    }
}
