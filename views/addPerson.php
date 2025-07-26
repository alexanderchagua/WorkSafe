<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<body>
    <h2 class="titulo-formulario"><i class="fas fa-hard-hat"></i> PPE Registration Form</h2>

    <form action="/worksafe/personal_epp/index.php" method="post" class="formulario-epp">
        
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
            <input type="file" name="foto" required class="input-text">
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

        <label><i class="fas fa-signature"></i> Digital Signature:
            <textarea name="firmar" class="input-area"></textarea>
        </label>

        <label><i class="fas fa-camera"></i> Captured Photo:
            <canvas name="foto_captura" class="input-area"></canvas>
        </label>

        <button type="submit" class="btn-enviar"><i class="fas fa-save"></i> Save</button>
    </form>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</html>
