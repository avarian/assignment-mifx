<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'published_year'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function scopeFilter($query, $params)
    {
        if ( isset($params['title']) && trim($params['title']) !== '') {
            $query->where('title', 'LIKE', '%' . trim($params['title']) . '%');
        }
        if ( isset($params['authors']) && trim($params['authors']) !== '') {
            $query->whereHas('authors', function($q) use ($params){
                $q->whereIn('id', explode(',', trim($params['authors'])));
            });
        }
        if ( isset($params['sortColumn']) && trim($params['sortColumn']) !== '') {
            $direction = (isset($params['sortDirection']) && strtoupper(trim($params['sortDirection'])) == "DESC") ? "DESC" : "ASC" ;
            if (trim($params['sortColumn']) == "avg_review") {
                $query->withCount(['reviews as average_review' => function($query) {
                    $query->select(DB::raw('coalesce(avg(review),0)'));
                }])->orderBy('average_review', $direction);
            } else {
                $query->orderBy(trim($params['sortColumn']), $direction);
            }
        }
        return $query;
    }
}
