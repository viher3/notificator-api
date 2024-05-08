<?php

namespace Apps\Api\src\Service\NelmioApiDoc;

use Nelmio\ApiDocBundle\Describer\DescriberInterface;
use Nelmio\ApiDocBundle\OpenApiPhp\Util;
use OpenApi\Annotations as OA;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

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
