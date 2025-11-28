document.addEventListener("DOMContentLoaded", cargarTickets);

async function cargarTickets() {
    const tickets = await apiGet(API_TICKETS + "/tickets/todos");

    const tbody = document.querySelector("#tablaTickets tbody");
    tbody.innerHTML = "";

    tickets.forEach(t => {
        tbody.innerHTML += `
        <tr>
            <td>${t.id}</td>
            <td>${t.titulo}</td>
            <td>${t.estado}</td>
            <td>${t.gestor_id}</td>
            <td>${t.admin_id ?? 'Sin asignar'}</td>
            <td>
                <button onclick="abrirTicket(${t.id})">Ver</button>
            </td>
        </tr>`;
    });
}

function abrirTicket(id) {
    window.location.href = "ticket.html?id=" + id;
}

function logout() {
    localStorage.clear();
    window.location.href = "index.html";
}