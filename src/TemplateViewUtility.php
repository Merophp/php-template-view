<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin;

/**
 * @author Robert Becker
 */
class TemplateViewUtility
{

    /**
     * @param string $identifier
     * @return array
     */
    public static function splitIdentifier(string $identifier): array
    {
        $identParts = explode('.', $identifier);
        $package = array_shift($identParts);
        $name = implode('.', $identParts);
        return [$package, $name];
    }
}
