<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

<form id="searchForm" method="GET" action="./search/index.php">
    <label for="nombre">Search by name:</label>
    <input type="text" id="nombre" name="nombre">

    <label for="area_trabajo">Search by work area:</label>
    <input type="text" id="area_trabajo" name="area_trabajo">

    <input type="submit" value="Search">
</form><br><br>

<div id="personList" class="person-list">
    <?php
    // Array to map abbreviations to full names
    $nombres_completos = array(
        'Cs' => 'Safety Helmet',
        'Oc' => 'Helmet Earmuffs',
        'Ov' => 'Headband Earmuffs',
        'Gbd' => 'Badana Gloves',
        'Zp' => 'Safety Shoes',
        'Ga' => 'Cut-resistant Gloves',
        'Gc' => 'Leather Gloves',
        'Gac' => 'Acid-resistant Gloves',
        'Mp' => 'Cleaning Gloves',
        'Gs' => 'Welding Gloves',
        'Cas' => 'Welding Helmet',
        'Cms' => 'Welding Shirt',
        'Hs' => 'Welding Shoulder Pads',
        'Ms' => 'Welding Apron',
        'Bs' => 'Welding Boots',
        'Ls' => 'Safety Glasses',
        'Pf' => 'Face Shield',
        'Fc' => 'Lifting Belt',
        'Lg' => 'Goggles',
        'R3m' => '3M Respirator',
        'Vo' => 'Organic Vapor Filter',
        'Fp' => 'Particle Filter',
        'Ta' => 'Acid Suit',
        'Chc' => 'Cold Room Jacket',
        'Pc' => 'Cold Room Pants',
        'Mc' => 'Cold Room Socks',
        'Pm' => 'Balaclava',
        'Cam' => 'Cold Room Gloves',
        'Tc' => 'Cold Room Suit',
        'Bb' => 'White Boots',
        'U' => 'Production Uniform',
        'Ua' => 'Warehouse Uniform',
        'Ul' => 'Cleaning Uniform',
        'Zc' => 'Cold Room Shoes',
        'Um' => 'Maintenance Uniform',
        'Bp' => 'Steel Toe Boots',
        'Tv' => 'Tyvek Suit',
    );

    // Check if the form has been submitted and if there are results to display
    if (!empty($personas)) {
        echo '<div class="marco">';
        echo '<h2>Search Results</h2>';
        echo '<ul id="personListUl">';
        foreach ($personas as $persona) {
            $persona['firmar'] = 'data:image/jpeg;base64,' . $persona['firmar'];
            $tiene_epp = false;
            foreach ($persona as $key => $value) {
                if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0') {
                    $tiene_epp = true;
                    break;
                }
            }
            if ($tiene_epp) {
                echo '<li>';
                echo '<div class="photo">';
                echo '<img src="' . $persona['foto'] . '" alt="' . $persona['name'] . '">';
                echo '</div>';
                echo '<span>';
                echo 'Status: <span class="' . ($persona['estado'] === 'activo' ? 'estado-activo' : 'estado-retirado') . '">' . $persona['estado'] . '</span><br>';
                echo 'Name: ' . $persona['name'] . '<br>';
                echo 'Age: ' . $persona['edad'] . '<br>';
                echo 'Occupation: ' . $persona['ocupacion'] . '<br>';
                echo 'Area: ' . $persona['area_trabajo'] . '<br>';
                echo 'Location: ' . $persona['sede'] . '<br>';
                echo 'Date of Entry: ' . $persona['fecha_ingreso'] . '<br>';
                echo 'Birthday: ' . $persona['fecha_cumple'] . '<br>';
                echo '</span>';
                echo '<span>';
                echo '<h2> Safety Equipment </h2>';
                echo '</span>';
                echo 'PPE Status: <span class="' . ($persona['estado_epp'] === 'devuelto' ? 'estado_epp_devuelto' : ($persona['estado_epp'] === 'activo' ? 'estado_epp_activos' : '')) . '">' . $persona['estado_epp'] . '</span><br>';
                echo 'Observations: ' . $persona['observaciones']. '<br>','<br>';

                $mostrado = [];

                foreach ($persona as $key => $value) {
                    if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0' && !empty($value)) {
                        $epp_nombre = ucwords(str_replace('', ' ', str_replace(['fecha_entrega_', 'cambio_'], '', $key)));
                        if (array_key_exists($epp_nombre, $nombres_completos)) {
                            $epp_nombre_completo = $nombres_completos[$epp_nombre];
                            if (!in_array($epp_nombre_completo, $mostrado)) {
                                echo $epp_nombre_completo . ':<br>';
                                echo 'Delivery Date: ' . $value . '<br>';
                                $cambio_key = str_replace('fecha_entrega_', 'cambio_', $key);
                                echo 'Replacement Date: ' . $persona[$cambio_key] . '<br>';
                                $mostrado[] = $epp_nombre_completo;
                            }
                        }
                    }
                }
                echo '<br>';
                echo '<h2>Signature</h2>';
                echo '<br>';
                echo '<td><img class="firma" src="' . htmlspecialchars($persona['firmar']) . '" alt="Signature" /></td>';
                echo '<br>';
                echo '<td><img src="data:image/png;base64,' . htmlspecialchars($persona['foto_captura']) . '" alt="Last Photo" width="300" height="225"></td>';
                echo '<h2>Evidence Photo</h2>';
                echo 'Signature Date: ' . htmlspecialchars($persona['fecha']) . '<br>';
                echo '</li>';
            }
        }
        echo '</ul>';
        echo '</div>';
        if ($_SESSION['clientData']['clientLevel'] == 3 || $_SESSION['clientData']['clientLevel'] == 4) {
            echo '<a href="../views/mpersonal.php?id=' . $persona['id'] . '" class="btn-modificar">Modify Data</a>';
        }
    } else {
        echo '<p>No results found for the search.</p>';
    }
    ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
