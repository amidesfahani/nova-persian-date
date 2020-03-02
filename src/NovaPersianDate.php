<?php

namespace Amidesfahani\NovaPersianDate;

use Exception;
use DateTimeInterface;
use Laravel\Nova\Fields\Field;

class NovaPersianDate extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-persian-date';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback ?? function ($value) {
            if (!is_null($value)) {
                if ($value instanceof DateTimeInterface) {
                    return $value->format('Y-m-d H:i:s');
                }

                throw new Exception("DateTime field must cast to 'datetime' in Eloquent model.");
            }
        });
    }

    /**
     * format based on jalali-moment. See https://github.com/jalaali/moment-jalaali
     *
     * @param  string  $format
     * @return PersianDateTime
     */
    public function format($format)
    {
        return $this->withMeta(compact('format'));
    }

    /**
     * Set datePicker Color. See https://talkhabi.github.io/vue-persian-datetime-picker/#/theme
     *
     * @param $color
     * @return PersianDateTime
     */
    public function color($color)
    {
        return $this->withMeta(compact('color'));
    }
}
