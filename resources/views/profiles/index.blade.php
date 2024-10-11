@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6">
                <h1>Perfil</h1>
            </div>
        </div>
    </section>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Foto de Perfil</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <div class="profile-pic-container" style="position: relative; display: inline-block;">
                                    @if ($user->getFirstMediaUrl('userGallery'))
                                        <img class="profile-user-img" style="width: 150px; height: 150px; border-radius: 50%;" src="{{$user->getFirstMediaUrl('userGallery') }}" alt="Foto de {{ $user->name }}">
                                    @else
                                        <img class="profile-user-img" style="width: 150px; height: 150px; border-radius: 50%;" src="{{ asset('img/userDefault.png') }}">
                                    @endif
                                    <button href="#" class="btn btn-outline-primary btn-sm edit-profile-pic" data-toggle="modal" data-target="#updateImage"
                                        style="position: absolute; bottom: 5px; right: 5px; background: white; border-radius: 10%; padding: 5px;">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                            </div>
                            <h3 class="profile-username text-center">{{ $user->name }} {{ $user->last_name }}</h3>
                            <p class="text-muted text-center">{{ $user->roles->first()->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Información de Perfil</h3>
                        </div>
                        <div class="card-body" id="userUpdateInformation" name="userUpdateInformation" style="display: none">
                            <form action="{{ route('profiles.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="nameUpdate" class="col-sm-2 col-form-label">
                                        Nombre
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="nameUpdate" name="nameUpdate" class="form-control" placeholder="Nombre" value="{{ $user->name }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastNameUpdate" class="col-sm-2 col-form-label">
                                        Apellidos
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="lastNameUpdate" name="lastNameUpdate" class="form-control" placeholder="Apellidos" value="{{ $user->last_name }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="emailUpdate" class="col-sm-2 col-form-label">
                                        Correo
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="email" id="emailUpdate" name="emailUpdate" class="form-control" placeholder="Correo" value="{{ $user->email }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success">
                                                Actualizar
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="cancelUpdate">
                                                Cancelar
                                            </button>
                                        </div>   
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body" id="userInformation" name="userInformation">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">
                                    Nombre
                                </label>
                                <div class="col-sm-10">
                                    <p class="form-control-plaintext">{{ $user->name }}</p>
                                </div>
                                <label for="lastName" class="col-sm-2 col-form-label">
                                    Apellidos
                                </label>
                                <div class="col-sm-10">
                                    <p class="form-control-plaintext">{{ $user->last_name }}</p>
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">
                                    Correo
                                </label>
                                <div class="col-sm-10">
                                    <p class="form-control-plaintext">{{ $user->email }}</p>
                                </div>
                                <div class="offset-sm-2 col-sm-10">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success" id="updateInformation" name="updateInformation">
                                            Editar datos
                                        </button>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editPassword">
                                            Cambiar contraseña
                                        </button>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if($user->hasRole('supervisor'))
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Foto del Departamento</h3>
                                </div>
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <div class="profile-pic-container" style="position: relative; display: inline-block;">
                                            @if ($user->getFirstMediaUrl('departmentGallery'))
                                                <img class="profile-user-img" style="width: 150px; height: 150px; border-radius: 50%;" src="{{$user->getFirstMediaUrl('departmentGallery')}}" alt="Foto del Departamento">
                                            @else
                                                <img class="profile-user-img" style="width: 150px; height: 150px; border-radius: 50%;" src="{{ asset('img/logo.png') }}">
                                            @endif
                                            <button href="#" class="btn btn-outline-primary btn-sm edit-profile-pic" data-toggle="modal" data-target="#editLogo{{ $user->id }}"
                                                style="position: absolute; bottom: 5px; right: 5px; background: white; border-radius: 10%; padding: 5px;">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Información del Departamento</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="departmentName" class="col-sm-4 col-form-label">Nombre del Departamento:</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $department->name }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="departmentDescription" class="col-sm-4 col-form-label">Descripción:</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $department->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @include('profiles.editImage')
        @include('profiles.editLogo')
        @include('profiles.editPassword')
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profiles/profile.css') }}">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#updateInformation').click(function() {
                $('#userInformation').toggle();
                $('#userUpdateInformation').toggle();
            });
            $('#cancelUpdate').click(function() {
                $('#userUpdateInformation').hide();
                $('#userInformation').show();
            });
            var successMessage = "{{ session('success') }}";
            var errorMessage = "{{ session('error') }}";
            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: successMessage,
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    window.location.href = "{{ route('profiles.index') }}";
                });
            }
            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    window.location.href = "{{ route('profiles.index') }}";
                });
            }
        });
    </script>
@stop
