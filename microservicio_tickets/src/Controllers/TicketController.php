<?php
namespace App\Controllers;

use App\Models\Ticket;
use App\Models\TicketActividad;

class TicketController
{
    
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

   
    public function ticketsGestor($req, $res, $args)
    {
        $id = $args["id"];
        $tickets = Ticket::where("gestor_id", $id)->get();

        return $res->withJson($tickets);
    }
public function todos($req, $res)
    {
        $tickets = Ticket::all();
        return $res->withJson($tickets);
    }

  
    public function cambiarEstado($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->estado = $data["estado"];
        $ticket->updated_at = date('Y-m-d H:i:s');
        $ticket->save();

        return $res->withJson(["message" => "Estado actualizado"]);
    }

   
    public function asignarAdmin($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->admin_id = $data["admin_id"];
        $ticket->save();

        return $res->withJson(["message" => "Administrador asignado"]);
    }

public function todos($req, $res)
    {
        $tickets = Ticket::all();
        return $res->withJson($tickets);
    }

   
    public function cambiarEstado($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->estado = $data["estado"];
        $ticket->updated_at = date('Y-m-d H:i:s');
        $ticket->save();

        return $res->withJson(["message" => "Estado actualizado"]);
    }

  
    public function asignarAdmin($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->admin_id = $data["admin_id"];
        $ticket->save();

        return $res->withJson(["message" => "Administrador asignado"]);
    }
    
    public function todos($req, $res)
    {
        $tickets = Ticket::all();
        return $res->withJson($tickets);
    }

 
    public function cambiarEstado($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->estado = $data["estado"];
        $ticket->updated_at = date('Y-m-d H:i:s');
        $ticket->save();

        return $res->withJson(["message" => "Estado actualizado"]);
    }

  
    public function asignarAdmin($req, $res)
    {
        $data = $req->getParsedBody();

        $ticket = Ticket::find($data["ticket_id"]);
        $ticket->admin_id = $data["admin_id"];
        $ticket->save();

return $res->withJson(["message" => "Administrador asignado"]);
    }

   
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

    
    public function historial($req, $res, $args)
    {
        $id = $args["id"];

        $actividad = TicketActividad::where("ticket_id", $id)->get();
        return $res->withJson($actividad);
    }
}