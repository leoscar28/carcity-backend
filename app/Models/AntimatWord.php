<?php

namespace App\Models;

use App\Domain\Contracts\AntimatWordContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntimatWord extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = AntimatWordContract::TABLE;
    protected $fillable = AntimatWordContract::FILLABLE;

    public static function replace(&$string)
    {
        $antimat_words = self::all();

        $words = $antimat_words->pluck(AntimatWordContract::WORD)->toArray();
        $replacement = $antimat_words->pluck(AntimatWordContract::REPLACEMENT)->toArray();

        if ($words) {
            $string = str_replace($words, $replacement, $string);
        }
    }
}
