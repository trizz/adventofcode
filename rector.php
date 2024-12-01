<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths(
        [
            __DIR__.'/src',
            __DIR__.'/data',
        ]
    );

    // define sets of rules
    $rectorConfig->sets(
        [
            LevelSetList::UP_TO_PHP_84,
            SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            SetList::TYPE_DECLARATION,
            SetList::NAMING,
            SetList::PRIVATIZATION,
            SetList::EARLY_RETURN,
        ]
    );
};
