const url = new URL(window.location.href);
const ticketId = url.searchParams.get("id");
const user = JSON.parse(localStorage.getItem("user"));

document.addEventListener("DOMContentLoaded", () => {
    cargarTicket();
    cargarActividad();
});

async function cargarTicket() {
    const tickets = await apiGet(API_TICKETS + "/tickets/todos");
    const ticket = tickets.find(t => t.id == ticketId);

    document.getElementById("infoTicket").innerHTML = `
        <h3>${ticket.titulo}</h3>
        <p><strong>Descripción:</strong> ${ticket.descripcion}</p>
        <p><strong>Estado:</strong> ${ticket.estado}</p>
    `;
}

async function cargarActividad() {
    const act = await apiGet(API_TICKETS + "/tickets/historial/" + ticketId);

    let html = "";
    act.forEach(a => {
        html += `
        <div class="comentario">
            <p><strong>Usuario ${a.user_id}:</strong> ${a.mensaje}</p>
            <small>${a.created_at}</small>
        </div>`;
  });

    document.getElementById("actividad").innerHTML = html;
}

async function agregarComentario() {
    const mensaje = document.getElementById("mensaje").value;

    const data = {
        ticket_id: ticketId,
        user_id: user.id,
        mensaje: mensaje
    };

    await apiPost(API_TICKETS + "/tickets/comentar", data);
    document.getElementById("mensaje").value = "";
    cargarActividad();
}

function logout() {
    localStorage.clear();
    window.location.href ="index.html";
}