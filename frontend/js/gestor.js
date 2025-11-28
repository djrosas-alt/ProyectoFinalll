document.addEventListener("DOMContentLoaded", cargarMisTickets);

const user = JSON.parse(localStorage.getItem("user"));


async function crearTicket() {
    const data = {
        titulo: document.getElementById("titulo").value,
        descripcion: document.getElementById("descripcion").value,
        gestor_id: user.id
    };

    await apiPost(API_TICKETS + "/tickets/crear", data);
    alert("Ticket creado");
    cargarMisTickets();
}


async function cargarMisTickets() {
    const tickets = await apiGet(API_TICKETS + "/tickets/gestor/" + user.id);

    const tbody = document.querySelector("#tablaMisTickets tbody");
    tbody.innerHTML = "";

    tickets.forEach(t => {
        tbody.innerHTML += `
        <tr>
            <td>${t.id}</td>
            <td>${t.titulo}</td>
            <td>${t.estado}</td>
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