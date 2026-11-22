@extends('brackets/admin-ui::admin.layout.master')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Establecer fecha de entrega</title>
    <link rel="icon" href="{{URL::asset('images/nuap.png')}}"/>
</head>

@section('content')
    <div class="container" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-block">
                        <auth-form
                                :action="'{{ url('/set-delivery-date') }}'"
                                :data="{}"
                                inline-template>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/set-delivery-date') }}" novalidate>
                                {{ csrf_field() }}
                                <div style="padding-top: 5px" class="auth-header">
                                    <p class="auth-subtitle text-center"><br>Ingresa la fecha de entrega para el pedido # {{ $order['id'] }}<br></p>
                                </div>
                                <div style="padding-top: 5px; padding-bottom: 2px" class="auth-body">
                                    @include('brackets/admin-auth::admin.auth.includes.messages')
                                    <div class="form-group" :class="{'has-danger': errors.has('email'), 'has-success': this.fields.email && this.fields.email.valid }">
                                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="hidden" value="{{ $order['id'] }}" name="order_id" id="order_id">
                    <div class="input-group">
                        <input value='{{ $order['delivery_date'] }}' required min="date()" class="form-control" id="deliver_date" name="deliver_date" placeholder="Estimado de entrega" type="datetime-local" />
                        <span class="input-group-append">
                            @if($order['delivery_date'] != null && $order['status'] != 'Entregado')
                                <button style="color: white" type="submit" class="btn btn-success"><i class="fa fa-calendar"></i>&nbsp; Actualizar</button>
                            @else
                                <button style="color: white" type="submit" class="btn btn-success"><i class="fa fa-calendar"></i>&nbsp; Agregar</button>
                            @endif
                        </span>
                    </div>
                                        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
                                    </div>

                                
                                    @if (isset($error))
                                        <div style="padding-top: 1px" class="">
                                            <p style="font-weight: bold;
                                                    text-align: center;
                                                    color: #e00032;
                                                    font-size: 12px;
                                                    letter-spacing: 0;
                                                    margin-bottom: 0;">
                                                <br>{{ $error }}<br></p>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </auth-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

