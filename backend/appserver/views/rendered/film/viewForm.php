<?php
                  if (@$create) {
                      $reset = true;
                      $action = 'Create';
                      $role = '';
                  } else {
                      $reset = false;
                      $action = 'Detail';
                      $role = "data-eprole='form'";
                  }
                  ?>
<form data-reset='<?php echo $reset ?>' id='frmFilm' action='?c=film&a=action<?php echo $action ?>' method='POST' <?php
    echo $role ?>
    ><div class='row'>
        <div class='col-sm-12'>
            <div class='form-group'>
                <h2>Datos de Film</h2>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='id'>id:</label><input readonly minlength='1' maxlength='100000' type='number'
                    class='form-control' id='id' name='id' />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='title'>title:</label><input minlength='1' maxlength='50' type='input' class='form-control'
                    id='title' name='title' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='year'>year:</label><input minlength='1' maxlength='4' type='input' class='form-control'
                    id='year' name='year' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='resume'>resume:</label><textarea class='form-control' id='resume' name='resume'
                    required></textarea>
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='image_cover'>image_cover:</label><input minlength='1' maxlength='30' type='input'
                    class='form-control' id='image_cover' name='image_cover' required />
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <button type='submit' class='btn btn-success' data-form='frmFilm'>Guardar</button>
            <?php
                if (@$create) {
                ?>
            <button type='reset' class='btn btn-danger'>Limpiar</button>
            <?php
                } else {
                  ?>
            <a href='?c=film&a=viewCreate' class='btn btn-info'>Nuevo registro</a>
            <?php
                }
                  ?>
            <a href='?c=film' class='btn btn-warning'>Ver todos los registros</a>

        </div>
        <hr class='d-sm-none'>
    </div>
</form>