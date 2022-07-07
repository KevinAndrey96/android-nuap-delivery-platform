
@extends('brackets/admin-ui::admin.layout.master')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Recuperar contraseña</title>
    <link rel="icon" href="{{URL::asset('images/nuap.png')}}"/>
</head>

@section('content')
    <div class="container" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-block">
                        <auth-form
                                :action="'{{ url('/send-code-recover-password') }}'"
                                :data="{}"
                                inline-template>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/send-code-recover-password') }}" novalidate>
                                {{ csrf_field() }}
                                <div style="padding-top: 5px" class="auth-header">
                                    <div class="center-block">
                                        <img src="{{URL::asset('images/nuap.png')}}" style="width:40%" class="img-responsive mx-auto d-block">
                                    </div>
                                    <p class="auth-subtitle text-center">Bienvenido a Nuap</p>
                                    <p class="auth-subtitle text-center"><br>Ingresa tu correo electrónico o tu número de celular para recuperar tu contraseña<br></p>
                                </div>
                                <div style="padding-top: 5px; padding-bottom: 2px" class="auth-body">
                                    @include('brackets/admin-auth::admin.auth.includes.messages')
                                    <div class="form-group" :class="{'has-danger': errors.has('email'), 'has-success': this.fields.email && this.fields.email.valid }">
                                        <div class="input-group input-group--custom">
                                            <div class="input-group-addon"><i class="input-icon input-icon--mail"></i></div>
                                            <input type="text" v-model="form.email" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': this.fields.email && this.fields.email.valid}" id="email" name="email" placeholder="Correo electrónico o celular" required>
                                        </div>
                                        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="remember" value="1">
                                        <button type="submit" class="btn btn-primary btn-block btn-spinner"><i class="fa"></i>Enviar</button>
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

@section('bottom-scripts')
    <script type="text/javascript">
        document.getElementById('password').dispatchEvent(new Event('input'));
    </script>
@endsection
