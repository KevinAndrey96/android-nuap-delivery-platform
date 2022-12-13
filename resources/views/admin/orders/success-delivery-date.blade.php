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
                                    <p class="auth-subtitle text-center"><br>Se ha establecido la fecha para la orden # {{ $order['id'] }}<br></p>
                                </div>
                                <div style="padding-top: 5px; padding-bottom: 2px" class="auth-body">
                                    @include('brackets/admin-auth::admin.auth.includes.messages')
                                    <div class="form-group" :class="{'has-danger': errors.has('email'), 'has-success': this.fields.email && this.fields.email.valid }">
                                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="hidden" value="{{ $order['id'] }}" name="order_id" id="order_id">
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

