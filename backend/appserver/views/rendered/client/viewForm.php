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
<form data-reset='<?php echo $reset ?>' id='frmClient' action='?c=client&a=action<?php echo $action ?>' method='POST'
    <?php echo $role ?>
    ><div class='row'>
        <div class='col-sm-12'>
            <div class='form-group'>
                <h2>Datos de Client</h2>
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
                <label for='dni'>dni:</label>
                <input minlength='1' maxlength='15' type='input'
                    class='form-control' id='dni' name='dni' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='name'>name:</label><input minlength='1' maxlength='15' type='input' class='form-control'
                    id='name' name='name' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='lastname'>lastname:</label><input minlength='1' maxlength='15' type='input'
                    class='form-control' id='lastname' name='lastname' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='second_lastname'>second_lastname:</label>
                <input minlength='1' maxlength='15' type='input'
                    class='form-control' id='second_lastname' name='second_lastname' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='address'>address:</label><input minlength='1' maxlength='15' type='input'
                    class='form-control' id='address' name='address' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='email'>email:</label><input minlength='1' maxlength='20' type='input' class='form-control'
                    id='email' name='email' required />
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <button type='submit' class='btn btn-success' data-form='frmClient'>Guardar</button>
            <?php
                if (@$create) {
                ?>
            <button type='reset' class='btn btn-danger'>Limpiar</button>
            <?php
                } else {
                  ?>
            <a href='?c=client&a=viewCreate' class='btn btn-info'>Nuevo registro</a>
            <?php
                }
                  ?>
            <a href='?c=client' class='btn btn-warning'>Ver todos los registros</a>

        </div>
        <hr class='d-sm-none'>
    </div>
</form>