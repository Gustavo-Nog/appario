<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colmeia extends Model
{
    protected $primaryKey = 'id_colmeia';

    protected $fillable = [
        'especie',
        'tamanho',
        'data_aquisicao',
        'apiario_id',
    ];

    /**
     * Cada colmeia pertence a um único apiario
     */
    public function apiario(): BelongsTo
    {
        return $this->belongsTo(Apiario::class, 'apiario_id', 'id_apiario');
    }
}