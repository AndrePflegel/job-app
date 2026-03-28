<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_seen_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isVisitor(): bool
    {
        return $this->role === 'visitor';
    }

    public function canCreateJobs(): bool
    {
        return $this->isAdmin() || $this->isUser();
    }

    public function canManageJob(JobListing $job): bool
    {
        return in_array($this->role, ['admin', 'user']);
    }

    public function canSeeInternalEditorInfo(): bool
    {
        return $this->isAdmin() || $this->isUser();
    }

    public function savedCompanies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    public function hasSavedCompany(Company $company): bool
    {
        return $this->savedCompanies()->where('company_id', $company->id)->exists();
    }

    public function savedCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function hasSavedCategory(Category $category): bool
    {
        return $this->savedCategories()->where('category_id', $category->id)->exists();
    }
}
