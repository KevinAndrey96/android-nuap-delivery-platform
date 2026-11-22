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
                                :action="'{{ url('/change-password') }}'"
                                :data="{}"
                                inline-template>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/change-password') }}" novalidate>
                                {{ csrf_field() }}
                                <input type="hidden" id="user" name="user" value="{{ $user }}">
                                <div style="padding-top: 5px" class="auth-header">
                                    <div class="center-block">
                                        <img src="{{URL::asset('images/nuap.png')}}" style="width:40%" class="img-responsive mx-auto d-block">
                                    </div>
                                    <p class="auth-subtitle text-center"><br>Ingresa el código que hemos enviado a tu correo electrónico o a tu celular, e ingresa tu nueva contraseña<br></p>
                                </div>
                                <div style="padding-top: 5px; padding-bottom: 2px" class="auth-body">
                                    @include('brackets/admin-auth::admin.auth.includes.messages')
                                    <div class="form-group" :class="{'has-danger': errors.has('code'), 'has-success': this.fields.code && this.fields.code.valid }">
                                        <label for="code">Código</label>
                                        <div class="input-group input-group--custom">
                                            <div class="input-group-addon"><i class="input-icon input-icon--mail"></i></div>
                                            <input type="text" v-model="form.code" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('code'), 'form-control-success': this.fields.code && this.fields.code.valid}" id="code" name="code" placeholder="Código" required>
                                        </div>
                                        <div v-if="errors.has('code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('code') }}</div>
                                    </div>
                                    
                                    <div class="form-group" :class="{'has-danger': errors.has('password'), 'has-success': this.fields.password && this.fields.password.valid }">
                                        <label for="password">Contraseña</label>
                                        <div class="input-group input-group--custom">
                                            <div class="input-group-addon"><i class="input-icon input-icon--lock"></i></div>
                                            <input type="password" v-model="form.password" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': this.fields.password && this.fields.password.valid}" id="password" name="password" placeholder="Contraseña" required>
                                        </div>
                                        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
                                    </div>
                                    
                                    <div class="form-group" :class="{'has-danger': errors.has('confirm_password'), 'has-success': this.fields.confirm_password && this.fields.confirm_password.valid }">
                                        <label for="confirm_password">Confirmar contraseña</label>
                                        <div class="input-group input-group--custom">
                                            <div class="input-group-addon"><i class="input-icon input-icon--lock"></i></div>
                                            <input type="password" v-model="form.confirm_password" class="form-control" :class="{'form-control-danger': errors.has('confirm_password'), 'form-control-success': this.fields.confirm_password && this.fields.confirm_password.valid}" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña" required>
                                        </div>
                                        <div v-if="errors.has('confirm_password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('confirm_password') }}</div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block btn-spinner"><i class="fa"></i>Recuperar contraseña</button>
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
