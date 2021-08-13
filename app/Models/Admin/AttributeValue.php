<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    public function attributeKey(){
        return $this->hasOne(AttributeKey::class,'id','attribute_key_id');
    }
}
