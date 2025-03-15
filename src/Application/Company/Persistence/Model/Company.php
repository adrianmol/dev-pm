<?php

namespace DevPM\Application\Company\Persistence\Model;

use DevPM\Application\Company\Persistence\Shared\Constant\CompanyConstant;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUlids;

    protected $fillable = [
        CompanyConstant::NAME,
        CompanyConstant::DESCRIPTION,
    ];
}
