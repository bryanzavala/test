<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light navbar-expand-lg">
          <span class="navbar-brand mb-0 h1">Transactions</span>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="/">Inicio</a>
              </li>
            </ul>
          </div>
        </nav>        
        <div class="jumbotron">
          @if(session('data'))
            <div class="alert alert-{{ session('data')['status'] == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
              {{ session('data')['message'] }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>          
          @endif
          @php
            $saldo = 0;
            foreach ($transactions as $transaction) {
              $saldo += $transaction->saldo;
            }
          @endphp
          <div style="text-align: right; padding-bottom: 10px">
            <div style="display: inline; border: 1px solid #333; padding: 3px; font-weight: bold;">Saldo Total: {{ $saldo }}</div>
          </div>
          <div style="text-align: right; padding-bottom: 15px"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearModal">
              Crear registro
            </button> </div>
          <div>
            <form class="row" action="/">
              @php
                $naturaleza = [];
                $beneficiario = [];
                foreach ($data as $item) {
                  array_push($naturaleza, $item->naturaleza);
                  array_push($beneficiario, $item->beneficiario);
                }
                $naturaleza = collect($naturaleza)->unique()->values()->all();
                $beneficiario = collect($beneficiario)->unique()->values()->all();
              @endphp
              <div class="form-group col-md-4">
                <select class="form-control" name="naturaleza">
                  <option selected disabled>SELECCIONE NATURALEZA</option>
                  @foreach($naturaleza as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <select class="form-control" name="beneficiario">
                  <option selected disabled>SELECCIONE BENEFICIARIO</option>
                  @foreach($beneficiario as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <button class="btn btn-primary">Filtrar</button>
              </div>
            </form>
          </div>
          @if($transactions->count() > 0)
          <table class="table table-striped table-bordered">
              <thead>
                  <tr>
                    <th>N°</th>
                      <th>ID</th>
                      <th>FECHA</th>
                      <th>BENEFICIARIO</th>
                      <th>SALIDAS</th>
                      <th>SALDO</th>
                      <th>BANCOS</th>
                      <th>TIPO_MOV</th>
                      <th>EMPRESA</th>
                      <th>NATURALEZA</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($transactions as $transaction)
                  <tr>
                    <td>{{ $i }}</td>
                      <td>{{ (string)$transaction->id }}</td>
                      <td>{{ $transaction->fecha }}</td>
                      <td>{{ $transaction->beneficiario }}</td>
                      <td>{{ $transaction->salidas }}</td>
                      <td>{{ $transaction->saldo }}</td>
                      <td>{{ $transaction->bancos }}</td>
                      <td>{{ $transaction->tipo_mov }}</td>
                      <td>{{ $transaction->empresa }}</td>
                      <td>{{ $transaction->naturaleza }}</td>
                      <td>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{ $transaction->id }}" data-fecha="{{ $transaction->fecha }}" data-beneficiario="{{ $transaction->beneficiario }}" data-salidas="{{ $transaction->salidas }}" data-saldo="{{ $transaction->saldo }}" data-bancos="{{ $transaction->bancos }}" data-tipo_mov="{{ $transaction->tipo_mov }}" data-empresa="{{ $transaction->empresa }}" data-naturaleza="{{ $transaction->naturaleza }}">Editar</button>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#borrarModal" data-id="{{ $transaction->id }}">Borrar</button>
                        </div>                          
                      </td>
                  </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
              </tbody>
          </table>
          @else
          <p>No hay resultados.</p>
          @endif
        </div>
    </div>
    {{-- Start Modal Create Form --}}
    <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="/transactions" method="POST">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="fecha" class="col-form-label">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
              </div>
              <div class="form-group">
                <label for="beneficiario" class="col-form-label">Beneficiario:</label>
                <input type="text" class="form-control" id="beneficiario" name="beneficiario" required>
              </div>
              <div class="form-group">
                <label for="salidas" class="col-form-label">Salidas:</label>
                <input type="number" class="form-control" id="salidas" name="salidas" required>
              </div>
              <div class="form-group">
                <label for="saldo" class="col-form-label">Saldo:</label>
                <input type="number" class="form-control" id="saldo" name="saldo" required>
              </div>
              <div class="form-group">
                <label for="bancos" class="col-form-label">Bancos:</label>
                <input type="text" class="form-control" id="bancos" name="bancos" required>
              </div>
              <div class="form-group">
                <label for="tipo_mov" class="col-form-label">Tipo de movimiento:</label>
                <input type="text" class="form-control" id="tipo_mov" name="tipo_mov" required>
              </div>
              <div class="form-group">
                <label for="empresa" class="col-form-label">Empresa:</label>
                <input type="text" class="form-control" id="empresa" name="empresa" required>
              </div>
              <div class="form-group">
                <label for="naturaleza" class="col-form-label">Naturaleza:</label>
                <input type="text" class="form-control" id="naturaleza" name="naturaleza" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Crear</button>
            </div>
          </form>
        </div>
      </div>
    </div>    
    {{-- End Modal Create Form --}}
    {{-- Start Modal Edit Form --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <input type="hidden" id="id" name="id">
              <div class="form-group">
                <label for="fecha" class="col-form-label">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
              </div>
              <div class="form-group">
                <label for="beneficiario" class="col-form-label">Beneficiario:</label>
                <input type="text" class="form-control" id="beneficiario" name="beneficiario" required>
              </div>
              <div class="form-group">
                <label for="salidas" class="col-form-label">Salidas:</label>
                <input type="number" class="form-control" id="salidas" name="salidas" step="any" required>
              </div>
              <div class="form-group">
                <label for="saldo" class="col-form-label">Saldo:</label>
                <input type="number" class="form-control" id="saldo" name="saldo" step="any" required>
              </div>
              <div class="form-group">
                <label for="bancos" class="col-form-label">Bancos:</label>
                <input type="text" class="form-control" id="bancos" name="bancos" required>
              </div>
              <div class="form-group">
                <label for="tipo_mov" class="col-form-label">Tipo de movimiento:</label>
                <input type="text" class="form-control" id="tipo_mov" name="tipo_mov" required>
              </div>
              <div class="form-group">
                <label for="empresa" class="col-form-label">Empresa:</label>
                <input type="text" class="form-control" id="empresa" name="empresa" required>
              </div>
              <div class="form-group">
                <label for="naturaleza" class="col-form-label">Naturaleza:</label>
                <input type="text" class="form-control" id="naturaleza" name="naturaleza" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
          </form>
        </div>
      </div>
    </div>    
    {{-- End Modal Edit Form --}}
    {{-- Start Modal Delete Form --}}
    <div class="modal fade" id="borrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
              <input type="hidden" id="id">
              <p>¿Estás seguro que deseas eliminar este registro?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
          </form>
        </div>
      </div>
    </div>    
    {{-- End Modal Delete Form --}}    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
          $('table').DataTable({
            dom: 'Bfrtip',
            buttons: [
              { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
            ]
          });
        });
        $('#exampleModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget)
          let id = button.data('id')
          let fecha = button.data('fecha')
          let beneficiario = button.data('beneficiario')
          let salidas = button.data('salidas')
          let saldo = button.data('saldo')
          let bancos = button.data('bancos')
          let tipo_mov = button.data('tipo_mov')
          let empresa = button.data('empresa')
          let naturaleza = button.data('naturaleza')
          var modal = $(this)
          modal.find('.modal-title').text('Editar ' + id)
          modal.find('form').attr('action', '/transactions/' + id)
          modal.find('.modal-body input#id').val(id)
          modal.find('.modal-body input#fecha').val(fecha)
          modal.find('.modal-body input#beneficiario').val(beneficiario)
          modal.find('.modal-body input#salidas').val(salidas)
          modal.find('.modal-body input#saldo').val(saldo)
          modal.find('.modal-body input#bancos').val(bancos)
          modal.find('.modal-body input#tipo_mov').val(tipo_mov)
          modal.find('.modal-body input#empresa').val(empresa)
          modal.find('.modal-body input#naturaleza').val(naturaleza)
        })
        $('#borrarModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget)
          let id = button.data('id')
          var modal = $(this)
          modal.find('.modal-title').text('Eliminar ' + id)
          modal.find('form').attr('action', '/transactions/' + id)
          modal.find('.modal-body input#id').val(id)
        })              
    </script>
</body>
</html>