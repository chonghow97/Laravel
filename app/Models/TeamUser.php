<?php

namespace App\Models;

use App\Actions\Jetstream\AddTeamMember;
use Laravel\Jetstream\Events\TeamMemberRemoved;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class TeamUser extends JetstreamTeam
{
    protected $fillable = [
        'team_id',
        'user_id',
        'role'
    ];

    protected $dispatchesEvents = [
        'created' => AddTeamMember::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamMemberRemoved::class,
    ];
}
