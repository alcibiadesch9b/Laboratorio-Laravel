<?php include 'includes/header.php'; ?>

<main class="flex-grow-1">
    <section class="py-5">
        <div class="container" style="max-width: 500px;">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Formulario de Registro de Aspirantes</h4>
                </div>
                <div class="card-body">

                    <form action="procesar.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre (Requerido):</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                   placeholder="Ej: Maria" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido (Requerido):</label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                   placeholder="Ej: Gonzalez" required>
                        </div>

                        <div class="mb-3">
                            <label for="identificacion" class="form-label">Identificación (Requerido):</label>
                            <input type="text" class="form-control" id="identificacion" name="identificacion"
                                   placeholder="Ej: 8-123-4567" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento (Requerido):</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Sexo (Requerido):</label>
                            <div class="btn-group w-100" role="group" aria-label="Sexo">
                                <input type="radio" class="btn-check" name="sexo" id="sexoH" value="Hombre" autocomplete="off" required>
                                <label class="btn btn-outline-primary" for="sexoH">Hombre</label>

                                <input type="radio" class="btn-check" name="sexo" id="sexoM" value="Mujer" autocomplete="off">
                                <label class="btn btn-outline-primary" for="sexoM">Mujer</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label">Fotografía del Aspirante (png, jpg, jpeg, gif, webp):</label>
                            <input type="file" class="form-control" id="foto" name="foto"
                                   accept=".png,.jpg,.jpeg,.gif,.webp" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Registrar Aspirante</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
