<?php

namespace DFM\FAQ\Models;

use DFM\FAQ\Contracts\FaqTranslation as FaqTranslationContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqTranslation
 *
 * @package DFM\FAQ
 * @property-read  int     $id
 * @property-read  string  $question
 * @property-read  string  $answer
 * @property-read  string  $locale
 */
class FaqTranslation extends Model implements FaqTranslationContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faq_translations';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['question', 'answer', 'locale'];
}
