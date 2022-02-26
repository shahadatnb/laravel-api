<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;
use App\Models\Book;

use Laravel\Passport\HasApiTokens;

class Author extends Model implements AuthenticateContract
{
    use HasFactory, HasApiTokens, Authenticatable;

    public $timestamps = false;

    protected $fillable = ["name", "email", "password", "phone_no"];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
