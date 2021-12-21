<?php
namespace Merophp\PhpTemplateViewPlugin\Link\Serializer;

use Psr\Link\LinkInterface;

/**
 * Generates HTML for a hypermedia link.
 * @author Robert Becker
 */
class LinkSerializerLinkTag
{

    /**
     * @param LinkInterface $link
     * @return string
     */
    public function serialize(LinkInterface $link): string
    {
        $template = '<link href="%s" rel="%s" %s/>';

        $attributes = '';
        foreach($link->getAttributes() as $key => $value){
            if( $value === false ) continue;

            if( $value === true ) $value = '';
            else $value = htmlspecialchars((string) $value);

            $attributes .= htmlspecialchars($key).'="'.$value.'" ';
        }

        return sprintf(
            $template,
            htmlspecialchars($link->getHref()),
            htmlspecialchars(implode(' ',$link->getRels())),
            $attributes
        );
    }

}
