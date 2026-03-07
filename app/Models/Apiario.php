<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apiario extends Model
{   
    protected $primaryKey = 'id_apiario';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'area',
        'coordenadas',
        'data_criacao',
        'nome',
        'pessoa_id',
    ];

    // Relação com pessoa (1:N)
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id_pessoa');
    }

    // Relação com endereço (1:1)
    public function enderecos()
    {
        return $this->hasOne(EnderecoApiario::class, 'apiario_id', 'id_apiario');
    }

    // Um apiário pode ter várias colmeias (1:N)
    public function colmeias(): HasMany
    {
        return $this->hasMany(Colmeia::class, 'apiario_id', 'id_apiario');
    }
}
