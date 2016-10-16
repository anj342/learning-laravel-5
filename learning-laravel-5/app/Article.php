<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model {

	//things a user can change
	//Allows these to be mass assigned
	protected $fillable = ['title',
							'body',
							'published_at',
							'user_id' //temporary
							];
							
	//this makes dates a Carbon instance
	protected $dates = ['published_at'];

	//scope + function name is the naming convention
	public function scopePublished($query) {
		$query->where('published_at', '<=', Carbon::now());
	}

	public function scopeUnpublished($query) {
		$query->where('published_at', '>', Carbon::now());
	}

	//set+ <NameofAttribute> + Attribute naming convention
	public function setPublishedAtAttribute($date) {
		$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
	}

	//An article is owned by a user
	public function user() {
		return $this->belongsTo('App\User');
	}

	public function tags(){
		return $this->belongsToMany('App\Tag')->withTimestamps();
	}

	public function getTagListAttribute() {
		return $this->tags->lists('id');
	}
}
