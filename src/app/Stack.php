<?php
namespace App;

use App\Scopes\EnabledScope;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{

    protected $fillable = ['name', 'description', 'enabled'];
    protected $hidden = ['pivot'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EnabledScope);
    }
    
    public function cards()
    {
        return $this->belongsToMany('App\Card');
    }

    public function scopeLightweight($query)
    {
        return $query->with(['cards' => function($query) {
                    $query->select('id');
                }]);
    }
}
