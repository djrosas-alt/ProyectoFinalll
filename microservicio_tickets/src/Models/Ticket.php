<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
    public $timestamps = false;

    protected $fillable = [
        "titulo",
        "descripcion",
        "estado",
        "gestor_id",
        "admin_id",
        "created_at",
        "updated_at"
    ];

    
    public function actividad()
    {
        return $this->hasMany(TicketActividad::class, "ticket_id");
    }
}