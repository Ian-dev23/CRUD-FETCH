const btnGuardar = document.getElementById("btnGuardar");
const alertPlaceholder = document.getElementById("alertPlaceholder");

// Evento para guardar o actualizar un producto
btnGuardar.addEventListener("click", guardarProducto);

// Carga la lista de productos al abrir la página
listarProductos();

function mostrarAlertaBootstrap(tipo, mensaje)
{
    alertPlaceholder.className = tipo === "success"
        ? "alert alert-success mt-3"
        : "alert alert-danger mt-3";

    alertPlaceholder.textContent = mensaje;
    alertPlaceholder.classList.remove("d-none");

    setTimeout(() => {
        alertPlaceholder.classList.add("d-none");
    }, 5000);
}

function guardarProducto()
{
    // Obtiene valores del formulario
    let codigo = document.getElementById("codigo").value.trim();
    let producto = document.getElementById("producto").value.trim();
    let precio = document.getElementById("precio").value.trim();
    let cantidad = document.getElementById("cantidad").value.trim();
    let departamento = document.getElementById("departamento").value.trim();

    // Validaciones de campos obligatorios
    if (codigo === "") {
        Swal.fire("Error", "Ingrese el código", "error");
        mostrarAlertaBootstrap("danger", "Ingrese el código");
        return;
    }

    if (producto === "") {
        Swal.fire("Error", "Ingrese el producto", "error");
        mostrarAlertaBootstrap("danger", "Ingrese el producto");
        return;
    }

    if (departamento === "") {
        Swal.fire("Error", "Ingrese el departamento", "error");
        mostrarAlertaBootstrap("danger", "Ingrese el departamento");
        return;
    }

    if (precio === "" || isNaN(precio) || Number(precio) < 0) {
        Swal.fire("Error", "Ingrese un precio válido", "error");
        mostrarAlertaBootstrap("danger", "Ingrese un precio válido");
        return;
    }

    if (cantidad === "" || isNaN(cantidad) || Number(cantidad) < 1) {
        Swal.fire("Error", "La cantidad debe ser mayor o igual a 1", "error");
        mostrarAlertaBootstrap("danger", "La cantidad debe ser mayor o igual a 1");
        return;
    }

    // Envía datos al servidor
    let datos = new FormData();
    datos.append("id", document.getElementById("id").value);
    datos.append("codigo", codigo);
    datos.append("producto", producto);
    datos.append("precio", precio);
    datos.append("cantidad", cantidad);
    datos.append("departamento", departamento);

    // Decide si guarda o modifica según el id
    let accion;
    switch (document.getElementById("id").value) {
        case "":
            accion = "Guardar";
            break;

        default:
            accion = "Modificar";
            break;
    }

    datos.append("Accion", accion);

    fetch("registrar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: data.message
            });
            mostrarAlertaBootstrap("success", data.message);
            limpiarFormulario();
            listarProductos();
        } else {
            let mensaje = data.message || "Ocurrió un error";
            if (data.errors) {
                const detalles = Object.values(data.errors).join(" \n");
                mensaje += `: ${detalles}`;
            }
            Swal.fire({
                icon: "error",
                title: "Error",
                text: mensaje
            });
            mostrarAlertaBootstrap("danger", mensaje);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message
        });
        mostrarAlertaBootstrap("danger", error.message);
    });
}

function listarProductos()
{
    // Solicita todos los productos al servidor
    let datos = new FormData();
    datos.append("Accion", "Listar");

    fetch("registrar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || "No se pudo obtener la lista");
        }

        let tabla = "";
        data.data.forEach(producto => {
            tabla += `
            <tr>
                <td>${producto.id}</td>
                <td>${producto.codigo}</td>
                <td>${producto.producto}</td>
                <td>${producto.precio}</td>
                <td>${producto.cantidad}</td>
                <td>${producto.departamento}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editar(${producto.id})">
                        Editar
                    </button>
                </td>
            </tr>
            `;
        });

        document.getElementById("tablaProductos").innerHTML = tabla;
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message
        });
        mostrarAlertaBootstrap("danger", error.message);
    });
}

function editar(id)
{
    // Pide los datos del producto para cargar el formulario
    let datos = new FormData();
    datos.append("Accion", "Buscar");
    datos.append("id", id);

    fetch("registrar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || "No se encontró el producto");
        }

        document.getElementById("id").value = data.data.id;
        document.getElementById("codigo").value = data.data.codigo;
        document.getElementById("producto").value = data.data.producto;
        document.getElementById("precio").value = data.data.precio;
        document.getElementById("cantidad").value = data.data.cantidad;
        document.getElementById("departamento").value = data.data.departamento;
        btnGuardar.textContent = "Actualizar";
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message
        });
        mostrarAlertaBootstrap("danger", error.message);
    });
}

function limpiarFormulario()
{
    // Limpia los campos del formulario después de guardar o cancelar
    document.getElementById("id").value = "";
    document.getElementById("codigo").value = "";
    document.getElementById("producto").value = "";
    document.getElementById("precio").value = "";
    document.getElementById("cantidad").value = "";
    document.getElementById("departamento").value = "";
    btnGuardar.textContent = "Registrar";
}