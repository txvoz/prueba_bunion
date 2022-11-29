<div class='row'><div class='col-sm-12'><h2>Lista de Clients</h2><br><div data-eprole='list'data-paginator='true' data-endpoint='?c=client&a=actionList' data-cb='printDataSource'><form  action='#' data-eprole='filter'>
                     <div class='row'>
                         <div class='col-3'>
                             <input placeholder='Buscar...' class='form-control' type='search' id='search' name='search' value='' />
                         </div>
                         <div class='col-2'>
                             <button class='btn btn-danger'>Buscar</button>
                         </div>
                     </div>
                 </form><br><table class='table table-striped'><thead class='bg-primary navbar-dark text-white'><tr><th data-property='id'>id</th>
<th data-property='dni'>dni</th>
<th data-property='name'>name</th>
<th data-property='lastname'>lastname</th>
<th data-property='second_lastname'>second_lastname</th>
<th data-property='address'>address</th>
<th data-property='email'>email</th>
<th data-btns='delete,edit,*detail'>Opciones</th></tr></thead><tbody class='list'></tbody></table><nav></nav></div><a href='?c=client&a=viewCreate' class='btn btn-info'>Nuevo registro</a></div></div>