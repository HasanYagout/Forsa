<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->type==1;
    }

    // In User model
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function bookmarkedJobs()
    {
        return $this->morphedByMany(Job::class, 'bookmarkable', 'bookmarks');
    }

    public function bookmarkedTenders()
    {
        return $this->morphedByMany(Tender::class, 'bookmarkable', 'bookmarks');
    }
    public function bookmarkedTraining()
    {
        return $this->morphedByMany(Training::class, 'bookmarkable', 'bookmarks');
    }

    public function hasBookmarkedJob(Job $job)
    {
        return $this->bookmarkedJobs()->where('bookmarkable_id', $job->id)->exists();
    }
    public function hasBookmarkedTraining(Training $training)
    {
        return $this->bookmarkedTraining()->where('bookmarkable_id', $training->id)->exists();
    }

    public function hasBookmarkedTender(Tender $tender)
    {
        return $this->bookmarkedTenders()->where('bookmarkable_id', $tender->id)->exists();
    }
    public function hasBookmarked($record)
    {
        return match(true) {
            $record instanceof \App\Models\Job => $this->hasBookmarkedJob($record),
            $record instanceof \App\Models\Tender => $this->hasBookmarkedTender($record),
            $record instanceof \App\Models\Training => $this->hasBookmarkedTraining($record),
            default => false
        };
    }

    public function getBookmarkType($record)
    {
        return match(true) {
            $record instanceof \App\Models\Job => 'job',
            $record instanceof \App\Models\Tender => 'tender',
            $record instanceof \App\Models\Training => 'training',
            default => null
        };
    }
}
