async function login() {
    let email = document.getElementById("email").value;
    let pass  = document.getElementById("password").value;
    let error = document.getElementById("error");

    if (!email || !pass) {
        error.textContent = "Todos los campos son obligatorios";
        return;
    }

    const data = {
        email: email,
        password: pass
    };

    const response = await apiPost(API_USUARIOS + "/usuarios/login", data);

    if (response.error) {
        error.textContent = response.error;
        return;
    }

    
    localStorage.setItem("token", response.token);
    localStorage.setItem("user", JSON.stringify(response.user));

  
    if (response.user.role === "administrador" || response.user.role === "admin") {
        window.location.href = "admin.html";
    } else if (response.user.role === "gestor") {
        window.location.href = "gestor.html";
    } else {
        error.textContent = "Rol no válido";
    }
}