<?php
namespace App;

use App\Scopes\EnabledScope;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    protected $fillable = ['name', 'content'];
    protected $hidden = ['pivot', 'enabled'];

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

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
    public function stacks()
    {
        return $this->belongsToMany('App\Stack');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
