<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
// use Illuminate\Database\Eloquent\SoftDeletes;

class AclGroup extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = ['id'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted()
    {
        // geração de uuid
        static::creating(fn(AclGroup $acl_group) => $acl_group->id = (string) Uuid::uuid4());
    }

}
