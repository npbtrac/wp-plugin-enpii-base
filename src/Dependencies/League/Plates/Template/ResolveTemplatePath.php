<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Template;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Exception\TemplateNotFound;

interface ResolveTemplatePath
{
    /**
     * @throws TemplateNotFound if the template could not be properly resolved to a file path
     */
    public function __invoke(Name $name): string;
}
