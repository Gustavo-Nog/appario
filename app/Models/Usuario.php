<?php

namespace App\Models;

use App\Notifications\UsuarioResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_usuario';

    // $fillable Atributos que podem ser preenchidos em massa (segurança contra mass assignment).
    protected $fillable = [
        'email',
        'password',
        'tipo_usuario'
    ];

    // $hidden Atributos que devem ser ocultados ao serializar o modelo (para JSON/array).
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // $casts Converte automaticamente atributos entre tipos PHP e do banco de dados.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $attributes = ['tipo_usuario' => 'PESSOA'];

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $email) => Str::lower($email)
        );
    }

    public function pessoa()
    {
        return $this->hasOne(Pessoa::class, 'usuario_id', 'id_usuario');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UsuarioResetPasswordNotification($token));
    }
}
