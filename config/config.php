<?php

declare(strict_types=1);

namespace Prooph\Demo;

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider('config/autoload/{{,*.}global,{,*.}local}.php'),
]);

return $aggregator->getMergedConfig();
