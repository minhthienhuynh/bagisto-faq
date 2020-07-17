<?php

namespace DFM\FAQ\Providers;

use DFM\FAQ\Models\Faq;
use DFM\FAQ\Models\FaqTranslation;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        Faq::class,
        FaqTranslation::class
    ];
}
