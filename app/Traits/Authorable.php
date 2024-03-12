<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * authorable trait for managing authors
 *
 * @method Illuminate\Database\Eloquent\Relations\BelongsTo createdBy()
 */
trait Authorable
{
    public function initializeAuthorable()
    {

        $this->setHidden(array_merge(['created_by_id', 'created_by_ip', 'created_by_agent', 'updated_by_id', 'updated_by_agent', 'updated_by_ip', 'deleted_at'], $this->hidden));
        // $this->append('updated');
    }

    public static function bootAuthorable()
    {
        static::creating(function ($model) {
            $model->created_by_id = auth()->guest() ? 1 : auth()->id();
            $model->created_by_agent = request()->server('HTTP_USER_AGENT');
            $model->created_by_ip = request()->ip();

        });

        static::updating(function ($model) {
            $model->updated_by_id = auth()->guest() ? 1 : auth()->id();
            $model->updated_by_agent = request()->server('HTTP_USER_AGENT');
            $model->updated_by_ip = request()->ip();

        });
    }

    protected function creator(): Attribute
    {

        return Attribute::make(
            get: function ($value, $attributes) {
                return 'brijesh';
            }
        );
    }

    /**
     * createdBy
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id')->select('name', 'id');
    }

    /**
     * updatedBy
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id')->select('name', 'id');
    }

    /**
     * getCreatedAtAttribute
     *
     * @param  mixed  $date
     */
    public function getCreatedAtAttribute($date): string
    {
        return date('d-m-Y  H:i:s', strtotime($date));
    }

    /**
     * getUpdatedAtAttribute
     *
     * @param  mixed  $date
     */
    public function getUpdatedAtAttribute($date): string
    {
        return date('d-m-Y  H:i:s', strtotime($date));
    }
}
