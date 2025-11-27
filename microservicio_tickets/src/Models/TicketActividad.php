<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketActividad extends Model
{
    protected $table = "ticket_actividad";
    public $timestamps = false;

    protected $fillable = [
        "ticket_id",
        "user_id",
        "mensaje",
        "created_at",
        "updated_at"
    ];
}