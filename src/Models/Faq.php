<?php

namespace DFM\FAQ\Models;

use DFM\FAQ\Contracts\Faq as FaqContract;
use Illuminate\Database\Eloquent\Collection;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Core\Models\ChannelProxy;

/**
 * Class Faq
 *
 * @package DFM\FAQ
 * @property-read  int         $id
 * @property-read  bool        $active
 * @property-read  Collection  $translations
 */
class Faq extends TranslatableModel implements FaqContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'active' => false,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['active'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are translation.
     *
     * @var array
     */
    public $translatedAttributes = ['question', 'answer', 'locale'];

    /**
     * The channels that belong to the faq.
     */
    public function channels()
    {
        return $this->belongsToMany(ChannelProxy::modelClass(), 'faq_channel');
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param  string       $childType
     * @param  mixed        $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|void|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        parent::resolveChildRouteBinding($childType, $value, $field);
    }
}
