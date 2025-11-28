<?php
namespace App\Controllers;

use App\Models\Ticket;
use App\Models\TicketActividad;

class TicketController
{
    // Crear ticket (gestor)
    public function crear($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::create([
            "titulo" => $data["titulo"],
            "descripcion" => $data["descripcion"],
            "estado" => "abierto",
            "gestor_id" => $data["gestor_id"],
            "admin_id" => null,
            "created_at" => date('Y-m-d H:i:s')
        ]);

        return $res->withJson(["message" => "Ticket creado", "ticket" => $ticket]);
    }

    // Tickets del gestor
    public function ticketsGestor($req, $res, $args)
    {
        $id = $args["id"];
        $tickets = Ticket::where("gestor_id", $id)->get();
        return $res->withJson($tickets);
    }
 // Todos los tickets (admin)
    public function todos($req, $res)
    {
        $tickets = Ticket::all();
        return $res->withJson($tickets);
    }

    // Cambiar estado
    public function cambiarEstado($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->estado = $data["estado"];
        $ticket->updated_at = date('Y-m-d H:i:s');
        $ticket->save();

        return $res->withJson(["message" => "Estado actualizado"]);
    }

    // Asignar administrador
    public function asignarAdmin($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->admin_id = $data["admin_id"];
        $ticket->save();

        return $res->withJson(["message" => "Administrador asignado"]);
    }
   // Agregar comentario
    public function comentar($req, $res)
    {
        $data = $req->getParsedBody();

        $comentario = TicketActividad::create([
            "ticket_id" => $data["ticket_id"],
            "user_id" => $data["user_id"],
            "mensaje" => $data["mensaje"],
            "created_at" => date('Y-m-d H:i:s')
        ]);

        return $res->withJson(["message" => "Comentario agregado", "comentario" => $comentario]);
    }

    // Historial del ticket
    public function historial($req, $res, $args)
    {
        $id = $args["id"];

        $actividad = TicketActividad::where("ticket_id", $id)->get();
        return $res->withJson($actividad);
    }
}