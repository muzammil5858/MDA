
<?php


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizedLoginRequest extends Model
{
    use HasFactory;

    protected $table = 'authorized_login_requests';

    protected $fillable = [
        'cnic',
        'phone_no',
        'email',
        'user_name',
        'password',
        'device_name',
        'device_model',
        'device_brand',
        'os',
        'os_version',
        'ip_address',
        'app_version',
        'request_datetime',
        'confirmation_status',
        'remarks',
        'profile_pic',
        'forced_password',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'request_datetime' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'forced_password' => 'integer',
    ];
}
