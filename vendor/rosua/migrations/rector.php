<?php

declare (strict_types=1);
namespace _YabeUkiyo;

use _YabeUkiyo\Rector\Config\RectorConfig;
use _YabeUkiyo\Rector\Php74\Rector\Property\TypedPropertyRector;
use _YabeUkiyo\Rector\Set\ValueObject\LevelSetList;
use _YabeUkiyo\Rector\Set\ValueObject\SetList;
use _YabeUkiyo\Rector\Set\ValueObject\DowngradeLevelSetList;
return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->paths([__DIR__ . '/src']);
    // define sets of rules
    $rectorConfig->sets([SetList::NAMING, SetList::CODE_QUALITY, SetList::CODING_STYLE, DowngradeLevelSetList::DOWN_TO_PHP_74, LevelSetList::UP_TO_PHP_74]);
    // register single rule
    $rectorConfig->rule(TypedPropertyRector::class);
};
