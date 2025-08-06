<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php

// Check if the user is logged in
if (!isset($_SESSION['clientData'])) {
    echo "<p style='color: red;'>Access denied. You must be logged in.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}

// Check if the user has level 1 access
if ($_SESSION['clientData']['clientLevel'] != 1) {
    echo "<p style='color: red;'>You do not have permission to access this page.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}
?>


<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../css/addperson.css">

<body>
    <div class="container">
        <h2 class="titulo-formulario"><i class="fas fa-hard-hat"></i> PPE Registration Form</h2>

        <form action="/worksafe/personal_epp/index.php" enctype="multipart/form-data" method="post" class="formulario-epp">
            
            <label><i class="fas fa-user"></i> Name:
                <input type="text" name="name" required class="input-text">
            </label>

            <label><i class="fas fa-hashtag"></i> Age:
                <input type="number" name="edad" required class="input-text">
            </label>

            <label><i class="fas fa-briefcase"></i> Occupation:
                <input type="text" name="ocupacion" required class="input-text">
            </label>

            <label><i class="fas fa-building"></i> Work Area:
                <input type="text" name="area_trabajo" required class="input-text">
            </label>

            <label><i class="fas fa-cake-candles"></i> Date of Birth:
                <input type="date" name="fecha_cumple" required class="input-date">
            </label>

            <label><i class="fas fa-calendar-check"></i> Date of Entry:
                <input type="date" name="fecha_ingreso" required class="input-date">
            </label>

            <label><i class="fas fa-toggle-on"></i> Status:
                <select name="estado" required class="select">
                    <option value="activo">Active</option>
                    <option value="retirado">Retired</option>
                </select>
            </label>

            <label><i class="fas fa-map-marker-alt"></i> Location:
                <select name="sede" required class="select">
                    <option value="LIMA">LIMA</option>
                    <option value="CHICLAYO">CHICLAYO</option>
                    <option value="AREQUIPA">AREQUIPA</option>
                    <option value="TARAPOTO">TARAPOTO</option>
                </select>
            </label>

            <label><i class="fas fa-image"></i> Photo (URL):
                <input type="file" name="foto" accept="image/*">
            </label>

            <label><i class="fas fa-shield-alt"></i> PPE Status:
                <select name="estado_epp" class="select">
                    <option value="">-- Select --</option>
                    <option value="Activo">Active</option>
                    <option value="Devuelto">Returned</option>
                </select>
            </label>

            <label><i class="fas fa-comment-dots"></i> Observations:
                <input type="text" name="observaciones" class="input-text">
            </label>

            <label><input type="checkbox" name="casco_seguridad"> <i class="fas fa-hard-hat"></i> Safety Helmet Delivered</label>
            <label><i class="fas fa-calendar-day"></i> Helmet Delivery Date:
                <input type="date" name="fecha_entrega_cs" class="input-date">
            </label>
            <label><i class="fas fa-calendar-plus"></i> Helmet Replacement Date:
                <input type="date" name="cambio_cs" class="input-date">
            </label>

            <label><input type="checkbox" name="orejeras_casco"> <i class="fas fa-headphones-alt"></i> Earmuffs Delivered</label>
            <label><i class="fas fa-calendar-day"></i> Earmuffs Delivery Date:
                <input type="date" name="fecha_entrega_oc" class="input-date">
            </label>
            <label><i class="fas fa-calendar-plus"></i> Earmuffs Replacement Date:
                <input type="date" name="cambio_oc" class="input-date">
            </label>

           

              <div>
                <label><i class="fas fa-signature"></i> Digital Signature:</label><br>
                <canvas id="firmaCanvas" width="400" height="200" style="border:1px solid #000;"></canvas><br>
                <button type="button" onclick="limpiarCanvas()">Limpiar Firma</button>
                <input type="hidden" id="firmar" name="firmar">
            </div>
 
            
        </div>
    
    
    </div>

            <button type="submit" class="btn-enviar"><i class="fas fa-save"></i> Save</button>
        </form>
    </div>
    <script >
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById('firmaCanvas');
            var ctx = canvas.getContext('2d');
            var drawing = false;
            var lastX = 0;
            var lastY = 0;

            // Rellenar el fondo del canvas con blanco
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Eventos del mouse para dibujar en el canvas
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseleave', stopDrawing);

            // Eventos táctiles para dispositivos móviles
            canvas.addEventListener('touchstart', function(e) {
                if (e.touches.length === 1) {
                    var touch = e.touches[0];
                    startDrawing(touch);
                }
            });

            canvas.addEventListener('touchmove', function(e) {
                if (e.touches.length === 1) {
                    e.preventDefault(); // Evitar el scroll mientras se dibuja
                    var touch = e.touches[0];
                    draw(touch);
                }
            });

            canvas.addEventListener('touchend', stopDrawing);

            // Función para empezar a dibujar
            function startDrawing(e) {
                drawing = true;
                [lastX, lastY] = getCanvasCoords(e);
            }

            // Función para dibujar en el canvas
            function draw(e) {
                if (!drawing) return;
                var [x, y] = getCanvasCoords(e);
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(x, y);
                ctx.strokeStyle = '#000';
                ctx.lineWidth = 2;
                ctx.stroke();
                [lastX, lastY] = [x, y];
            }

            // Función para obtener la posición X e Y en el canvas
            function getCanvasCoords(e) {
                var rect = canvas.getBoundingClientRect();
                var clientX = e.clientX || e.touches[0].clientX;
                var clientY = e.clientY || e.touches[0].clientY;
                return [clientX - rect.left, clientY - rect.top];
            }

            // Función para detener el dibujo
            function stopDrawing() {
                drawing = false;
            }

            // Escuchar el evento submit del formulario
            document.getElementById('modificarForm').addEventListener('submit', function(event) {
                // Prevenir el envío automático del formulario
                event.preventDefault();
                // Guardar la firma antes de enviar el formulario
                guardarFirma();
            });

            // Función para obtener la imagen base64 del canvas como JPEG o PNG y asignarla al input hidden
           
            function guardarFirma() {
    var dataURL = canvas.toDataURL('image/jpeg');
    var base64Data = dataURL.split(',')[1];
    document.getElementById('firmar').value = base64Data;
    document.getElementById('modificarForm').submit();
}

            // Función para limpiar el canvas de la firma
            window.limpiarCanvas = function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'white'; // Asegurarse de que el fondo vuelva a ser blanco
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }
        });
    // Vis
    
    
    </script>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</html>
