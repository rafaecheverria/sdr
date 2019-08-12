<div class="sidebar" data-color="red" data-image="{{ asset('static/img/sidebar-1.jpg') }}">

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                Ct
            </a>
            <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                Creative Tim
            </a>
        </div>
        <div class="user">
            <div class="photo">
                <img src="{{asset('static/img/default-avatar.png')}}" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>{{Auth::User()->nombres}}
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a class="profile-dropdown" href="#pablo">
                                <span class="sidebar-mini">MP</span>
                                <span class="sidebar-normal">Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a class="profile-dropdown" href="#pablo">
                                <span class="sidebar-mini">CV</span>
                                <span class="sidebar-normal">Curriculum</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
        
            @role('Postulante')
            <br>
            <li>
                <div class="col-md-12">
                    <div class="progress" rel="tooltip" title="Curriculum incompleto">
                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="60" aria-valuemin="10" aria-valuemax="100" style="width:{{Auth::User()->porcentaje}}%;">
                            <span>{{Auth::User()->porcentaje}}%</span>
                        </div>
                    </div>
                    
                </div>
            </li>
            <hr>

            @endrole
            

            <li @click="menu=3" class="nav-item ">
                <a href="javascript:void(0)" class="nav-link" >
                    <i class="nc-icon nc-notes"></i>
                    <p>
                        Vacantes
                    </p>
                </a>
            </li>
            <li @click="menu=9" class="nav-item ">
                <a href="javascript:void(0)" class="nav-link" >
                    <i class="nc-icon nc-badge"></i>
                    <p>
                        Mi Curriculum
                    </p>
                   
                </a>
                
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#mantenimiento">
                    <i class="nc-icon nc-app"></i>
                    <p>
                        Mantenimiento
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="mantenimiento">
                    <ul class="nav">
                        <li @click="menu=1" class="nav-item">
                            <a href="#" class="nav-link">
                                <span class="sidebar-mini">E</span>
                                <span class="sidebar-normal">Empresas</span>
                            </a>
                        </li>
                        <li @click="menu=2" class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">
                                <span class="sidebar-mini">C</span>
                                <span class="sidebar-normal">Cargos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
       

            @can('ver personas')

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#personas">
                <i class="nc-icon nc-circle-09"></i>
                    <p>
                        Personas
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="personas">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a @click="menu=7" href="javascript:void(0)" class="nav-link">
                                <span class="sidebar-mini">PS</span>
                                <span class="sidebar-normal">Postulantes</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a @click="menu=8" class="nav-link" href="javascript:void(0)">
                                <span class="sidebar-mini">MD</span>
                                <span class="sidebar-normal">Moderador</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @endcan
        
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                <i class="nc-icon nc-settings-gear-64"></i>
                    <p>
                        Configuracion
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a @click="menu=4" href="javascript:void(0)" class="nav-link">
                                <span class="sidebar-mini">US</span>
                                <span class="sidebar-normal">Usuarios</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a @click="menu=5" class="nav-link" href="javascript:void(0)">
                                <span class="sidebar-mini">RL</span>
                                <span class="sidebar-normal">Roles</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a @click="menu=6" class="nav-link" href="javascript:void(0)">
                                <span class="sidebar-mini">PM</span>
                                <span class="sidebar-normal">Permisos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

           

        </ul>
    </div>
</div>