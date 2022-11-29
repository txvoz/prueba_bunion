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
<form data-reset='<?php echo $reset ?>' id='frmRent' action='?c=rent&a=action<?php echo $action ?>' method='POST' <?php
    echo $role ?>
    ><div class='row'>
        <div class='col-sm-12'>
            <div class='form-group'>
                <h2>Datos de Rent</h2>
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
                <label for='rent_date'>rent_date:</label><input minlength='1' maxlength='datetime' type='input'
                    class='form-control' id='rent_date' name='rent_date' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='limit_date'>limit_date:</label><input minlength='1' maxlength='datetime' type='input'
                    class='form-control' id='limit_date' name='limit_date' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='return_date'>return_date:</label><input minlength='1' maxlength='datetime' type='input'
                    class='form-control' id='return_date' name='return_date' required />
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='cli_id'>cli_id:</label><select required class='form-control' id='cli_id' name='cli_id'>
                    <option value=''>[SELECCIONE OPCION]</option>
                    <?php foreach ($clients as $entity) {
                    echo "<option value='{$entity->getId()}'>{$entity->describeStr()}</option>";
                } ?>
                </select>
            </div>
        </div>
        <div class='col-sm-4'>
            <div class='form-group'>
                <label for='cop_id'>cop_id:</label><select required class='form-control' id='cop_id' name='cop_id'>
                    <option value=''>[SELECCIONE OPCION]</option>
                    <?php foreach ($copies as $entity) {
                    echo "<option value='{$entity->getId()}'>{$entity->describeStr()}</option>";
                } ?>
                </select>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <button type='submit' class='btn btn-success' data-form='frmRent'>Guardar</button>
            <?php
                if (@$create) {
                ?>
            <button type='reset' class='btn btn-danger'>Limpiar</button>
            <?php
                } else {
                  ?>
            <a href='?c=rent&a=viewCreate' class='btn btn-info'>Nuevo registro</a>
            <?php
                }
                  ?>
            <a href='?c=rent' class='btn btn-warning'>Ver todos los registros</a>

        </div>
        <hr class='d-sm-none'>
    </div>
</form>