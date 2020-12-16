@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item active">FAQs</li>
  </ol>

  @include('flash::message')

  <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title mb-0">Todas las Preguntas Frecuentes</h4>
                  </div>
                  <div class="col-md-6" align="right">
                   {{--   <a href="{{ route('admin.faqs.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Nueva
                      </a> --}}
                  </div>
                  <div class="col-md-12">
                    <br>
                    <table id="table-faqs" class="display">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                                {{-- <th>Acciones</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($faqs as $faq)
                            <tr align="center">
                                <td>{{ $faq->id }}</td>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->answer}}</td>
                                {{-- <td>
                                  <ul class="list-inline" style="margin: 0px;">
                                    <li class="list-inline-item">
                                      <a class="btn btn-success btn-sm" href="{{ route('admin.faqs.edit', $faq->id) }}" title="{{ trans('Editar FAQ') }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i>
                                      </a>
                                    </li>
                                    <li class="list-inline-item">
                                      {!! Form::open([
                                          'class'=>'delete',
                                          'url'  => route('admin.faqs.destroy', $faq->id),
                                          'method' => 'DELETE',
                                          ])
                                      !!}
                                          <button class="btn btn-danger btn-sm" title="{{ trans('Eliminar') }}"><i class="fa fa-trash-o"></i></button>
                                      {!! Form::close() !!}
                                    </li>
                                  </ul>
                                </td> --}}
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@push('script')

<script>
   @if(App::isLocale('es'))
        $('#table-faqs').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             },
             "responsive": true,
             "bSort": false
        });
    @else
       $('#table-faqs').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/English.json"
             },
             "responsive": true,
             "bSort": false
       });
    @endif
</script>

@endpush

@endsection
