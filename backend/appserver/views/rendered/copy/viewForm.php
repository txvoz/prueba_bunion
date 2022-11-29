
                  <?php
                  if(@$create){
                    $reset = true;
                    $action = 'Create';
                    $role = '';
                  }else{
                    $reset = false;
                    $action = 'Detail';
                    $role = "data-eprole='form'";
                  }
                  ?>
                  <form data-reset='<?php echo $reset ?>' 
                      id='frmCopy' 
                      action='?c=copy&a=action<?php echo $action ?>' 
                      method='POST' 
                      <?php echo $role ?>
                      ><div class='row'>
        <div class='col-sm-12'>
                <div class='form-group'>
                    <h2>Datos de Copy</h2>
                </div>
            </div>
        </div><div class='row'><div class='col-sm-4'>
            <div class='form-group'>
                <label for='id'>id:</label><input readonly 
                    minlength='1' 
                    maxlength='100000' 
                    type='number' 
                    class='form-control' 
                    id='id' 
                    name='id' 
                     /></div>
            </div><div class='col-sm-4'>
            <div class='form-group'>
                <label for='status'>status:</label><select required class='form-control'id='status'name='status'><option value=''>[SELECCIONE OPCION]</option><option value='new'>new</option></select></div>
            </div><div class='col-sm-4'>
            <div class='form-group'>
                <label for='format'>format:</label><select required class='form-control'id='format'name='format'><option value=''>[SELECCIONE OPCION]</option><option value='cd'>cd</option></select></div>
            </div><div class='col-sm-4'>
            <div class='form-group'>
                <label for='price'>price:</label><input  
                    minlength='1' 
                    maxlength='100000' 
                    type='number' 
                    class='form-control' 
                    id='price' 
                    name='price' 
                    required /></div>
            </div><div class='col-sm-4'>
            <div class='form-group'>
                <label for='fil_id'>fil_id:</label><select required class='form-control'id='fil_id'name='fil_id'><option value=''>[SELECCIONE OPCION]</option><?php foreach ($s as $entity) {echo "<option value='{$entity->getId()}'>{$entity->describeStr()}</option>";} ?></select></div>
            </div></div><div class='row'>
            <div class='col-sm-12'>
                <button type='submit' 
                        class='btn btn-success' 
                        data-form='frmCopy'>Guardar</button>
                <?php
                  if(@$create){
                  ?>
                  <button type='reset' 
                        class='btn btn-danger' 
                        >Limpiar</button>
                  <?php
                  }else{
                  ?>
                  <a href='?c=copy&a=viewCreate' class='btn btn-info'>Nuevo registro</a>
                  <?php
                  }
                  ?>
                <a href='?c=copy' class='btn btn-warning'>Ver todos los registros</a>
                                
            </div>
            <hr class='d-sm-none'>
        </div></form>