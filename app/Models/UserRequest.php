<?php

namespace App\Models;

use App\Domain\Contracts\UserRequestContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = UserRequestContract::TABLE;
    protected $fillable = UserRequestContract::FILLABLE;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'name', 'surname']);
    }

    public function brand(){
        return $this->hasOne(DictionaryBrand::class, 'id', 'brand_id')->select(['id', 'name']);
    }

    public function category(){
        return $this->hasOne(DictionarySparePart::class, 'id', 'category_id')->select(['id', 'name']);
    }
}
