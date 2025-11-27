
const API_USUARIOS = "http://localhost/microservicio_usuarios/public";
const API_TICKETS  = "http://localhost/microservicio_tickets/public";


function authHeaders() {
    const token = localStorage.getItem("token");
    return {
        "Content-Type": "application/json",
        "Authorization": token ?? ""
    };
}


async function apiPost(url, data) {
    const res = await fetch(url, {
        method: "POST",
        headers: authHeaders(),
        body: JSON.stringify(data)
    });
    return res.json();
}


async function apiPut(url, data) {
    const res = await fetch(url, {
        method: "PUT",
        headers: authHeaders(),
        body: JSON.stringify(data)
    });
    return res.json();
}

async function apiGet(url) {
    const res = await fetch(url, {
        method: "GET",
        headers: authHeaders()
    });
    return res.json();
}


async function apiDelete(url) {
    const res = await fetch(url, {
        method: "DELETE",
        headers: authHeaders()
    });
    return res.json();
}