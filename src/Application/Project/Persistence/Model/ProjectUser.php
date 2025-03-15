<?php

namespace DevPM\Application\Project\Persistence\Model;

use DevPM\Application\User\Persistence\Model\User;
use DevPM\Infrastructure\Constants\CommonConstants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectUser extends Model
{
    use HasUlids;

    protected $fillable = [
        CommonConstants::PROJECT_ID,
        CommonConstants::USER_ID,
    ];

    public $timestamps = false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
