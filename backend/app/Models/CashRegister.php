<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'movement',
        'purchase_id',
        'comanda_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_by = $user->id;
            }
        });

        static::created(function () {
            $dashboard = Dashboard::firstOrCreate([]);
            $dashboard->save();
        });

        static::deleted(function () {
            $dashboard = Dashboard::firstOrCreate();
            $dashboard->save();
        });
    }

        public function comandas()
    {
        return $this->hasMany(Comanda::class);
    }

        public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
