<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;


    protected $table="job_listings";

    protected  $fillable = ['user_id',
                'title',
                'description',
                'salary',
                'tags',
                'job_type',
                'remote',
                'requirements',
                'benefits',
                'address',
                'city',
                'state',
                'zipcode',
                'contact_email',
                'contact_phone',
                'company_name',
                'company_description',
                'company_logo',
                'company_website'];

    //Relation to User class
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

