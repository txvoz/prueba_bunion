<div class='row'>
    <div class='col-sm-12'>
        <h2>Lista de Films</h2><br>
        <div data-eprole='list' data-paginator='true' data-endpoint='?c=film&a=actionList' data-cb='printDataSource'>
            <form action='#' data-eprole='filter'>
                <div class='row'>
                    <div class='col-3'>
                        <input placeholder='Buscar...' class='form-control' type='search' id='search' name='search'
                            value='' />
                    </div>
                    <div class='col-2'>
                        <button class='btn btn-danger'>Buscar</button>
                    </div>
                </div>
            </form><br>
            <table class='table table-striped'>
                <thead class='bg-primary navbar-dark text-white'>
                    <tr>
                        <th data-property='id'>id</th>
                        <th data-property='title'>title</th>
                        <th data-property='year'>year</th>
                        <th data-property='resume'>resume</th>
                        <th data-property='image_cover'>image_cover</th>
                        <th data-btns='delete,edit,*detail'>Opciones</th>
                    </tr>
                </thead>
                <tbody class='list'></tbody>
            </table>
            <nav></nav>
        </div><a href='?c=film&a=viewCreate' class='btn btn-info'>Nuevo registro</a>
    </div>
</div>