<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Model;
use App\Models\common\File;


class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $fillable = [
        'name',
        'slogan',
        'business',
        'bio',
        'type',
        'email',
        'email2',
        'supportEmail',
        'phone',
        'phone2',
        'supportPhone',
        'country',
        'address',
        'city',
        'country_code',
        'website',
        'currency',
        'zip_code',
        'taxNumber',
        'registrationNumber',
        'registrationDate',
        'bankAccount',
        'bankAccount2',
        'pdf_profile',
        'logo',
        'status',
        // Module settings
        'enable_construction',
        'enable_partners',
        'enable_real_estate',
        'default_management_fee',
    ];
    
    protected $casts = [
        'enable_construction' => 'boolean',
        'enable_partners' => 'boolean',
        'enable_real_estate' => 'boolean',
        'default_management_fee' => 'decimal:2',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'referable');
    }
}
