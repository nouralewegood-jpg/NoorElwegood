<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    // السماح بالتعيين الجماعي لعمود البريد الإلكتروني
    protected $fillable = ['email'];
}
