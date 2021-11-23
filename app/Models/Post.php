<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCan;

class Post extends Model
{
    use HasFactory;
    use HasCan;

    protected $table = 'posts'; 
    
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];
    protected $appends = [
        'can'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return now()->parse($value)->timezone(config('app.timezone'))->format('d F Y, H:i:s');
        # code...
    }
    public function getUpdatedAtAttribute($value)
    {
        return now()->parse($value)->timezone(config('app.timezone'))->diffForHumans();
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null,function($query, $search){
            $query->where(function($query) use ($search){
                $query->where('title','like','%'.$search. '%')
                    ->orWhere('content','like','%'.$search.'%');
            });
        });
    }
}
