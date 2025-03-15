<?php

namespace DevPM\Application\Project\Persistence\Model;

use DevPM\Application\Company\Persistence\Model\Company;
use DevPM\Application\Project\Persistence\Shared\Constant\ProjectConstant;
use DevPM\Application\User\Persistence\Model\User;
use DevPM\Infrastructure\Constants\Tables\TablesConstants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasUlids;

    protected $fillable = [
        ProjectConstant::NAME,
        ProjectConstant::COMPANY_ID,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, TablesConstants::PROJECT_USERS);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
