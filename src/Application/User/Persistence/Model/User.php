<?php

namespace DevPM\Application\User\Persistence\Model;

use DevPM\Application\Project\Persistence\Model\Project;
use DevPM\Application\User\Persistence\Shared\Constant\UserConstant;
use DevPM\Infrastructure\Constants\Tables\TablesConstants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUlids, HasApiTokens, HasRoles;

    protected $fillable = [
        UserConstant::NAME,
        UserConstant::EMAIL,
        UserConstant::PASSWORD,
    ];

    protected $hidden = [
        UserConstant::PASSWORD,
        UserConstant::REMEMBER_TOKEN,
    ];

    protected function casts(): array
    {
        return [
            UserConstant::EMAIL_VERIFIED_AT => 'datetime',
            UserConstant::PASSWORD => 'hashed',
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, TablesConstants::PROJECT_USERS);
    }
}
