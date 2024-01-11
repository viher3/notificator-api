<?php

namespace Apps\Api\src\Controller\NelmioApiDoc;

use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Describer\DescriberInterface;
use Symfony\Component\Yaml\Yaml;
use Nelmio\ApiDocBundle\OpenApiPhp\Util;
use Symfony\Component\Finder\Finder;

class ExternalDocDescriber implements DescriberInterface
{
    private const OPEN_API_FILES_DIR = __DIR__ . '/../../../docs';

    /**
     * @param OA\OpenApi $api
     * @return void
     */
    public function describe(OA\OpenApi $api)
    {
        $finder = new Finder();
        $finder->files()->in(self::OPEN_API_FILES_DIR)->name('*.yaml');

        foreach ($finder as $file) {
            Util::merge($api, Yaml::parseFile($file));
        }
    }
}
