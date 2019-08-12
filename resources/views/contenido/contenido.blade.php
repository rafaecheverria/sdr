@extends('layouts.principal')

@section('content')
        <div class="content">
                <div class="container-fluid">
                        <div class="row">
                                <div class="col-lg-12">

                                        <template v-if="menu==0">
                                                <page-home></page-home>
                                        </template>

                                        <template v-if="menu==1">
                                                <page-empresas></page-empresas>
                                        </template>

                                        <template v-if="menu==2">
                                                <page-cargos></page-cargos>
                                        </template>

                                        <template v-if="menu==3">
                                                <page-vacantes></page-vacantes>
                                        </template>
                                        <template v-if="menu==4">
                                                <page-usuarios :auth="{{Auth::User()}}"></page-usuarios>
                                        </template>

                                        <template v-if="menu==5">
                                                <page-roles :auth="{{Auth::User()}}"></page-roles>
                                        </template>

                                        <template v-if="menu==6">
                                                <page-permisos :auth="{{Auth::User()}}"></page-permisos>
                                        </template>

                                        <template v-if="menu==7">
                                                <page-postulantes :auth="{{Auth::User()}}"></page-postulantes>
                                        </template>

                                        <template v-if="menu==8">
                                                <page-moderadores :auth="{{Auth::User()}}"></page-moderadores>
                                        </template>

                                        <template v-if="menu==9">
                                                <page-curriculum :auth="{{Auth::User()}}"></page-curriculum>
                                        </template>
                                        
                                </div>
                        </div>
                </div>
        </div>
    
@stop