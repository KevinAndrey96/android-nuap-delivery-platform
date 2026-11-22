@extends('brackets/admin-ui::admin.layout.default')

<head>
    <title>Cuenta Bancaria</title>
    <link rel="icon" href="{{URL::asset('images/nuap.png')}}"/>
</head>

@section('body')
    <div class="container-xl">
        <div class="card">
            <form id="form-basic" method="post" enctype="multipart/form-data" action="{{ url('admin/payment-store') }}">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <form class="form-horizontal form-create">
                    <div class="card-header">
                        <i class="fa fa-bank"></i>&nbsp; Cuenta Bancaria
                    </div>

                    <div class="card-body">
                        @include('admin.payments.components.form-create-elements')
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-download"></i>
                            &nbsp; Guardar
                        </button>
                        <div class="pull-right">
                            @if($account['status'] === 1)
                            <button disabled style="color: white" class="btn btn-success"><i></i>&nbspAprobada</button>
                            @endif
                            @if($account['status'] === 0)
                                <button disabled style="color: white" class="btn btn-danger"><i></i>&nbspPendiente</button>
                            @endif    
                        </div>
                    </div>
                </form>
            </form>
        </div>
    </div>
@endsection
