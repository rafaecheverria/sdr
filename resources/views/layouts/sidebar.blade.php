<div class="sidebar" data-color="black" data-image="{{ asset('static/img/sidebar-5.jpg') }}">

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                IÑ
            </a>
            <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                INTEGRA ÑUBLE
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
                                <span class="sidebar-normal">Departamentos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">          

        <br>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#documentos">
                <i class="nc-icon nc-notes"></i>
                    <p>
                        Documentos
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="documentos">
                    <ul class="nav">
                        <li @click="menu=11" class="nav-item">
                            <a href="#" class="nav-link">
                                <span class="sidebar-mini">+</span>
                                <span class="sidebar-normal">Crear Documento</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="collapse " id="documentos">
                    <ul class="nav">
                        <li @click="menu=12" class="nav-item">
                            <a href="#" class="nav-link">
                                <span class="sidebar-mini">VD</span>
                                <span class="sidebar-normal">Ver Documentos</span>
                            </a>
                        </li>
                    </ul>
                </div>
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
                                <span class="sidebar-mini">D</span>
                                <span class="sidebar-normal">Departamentos</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse " id="mantenimiento">
                    <ul class="nav">
                        <li @click="menu=13" class="nav-item">
                            <a href="#" class="nav-link">
                                <span class="sidebar-mini">A</span>
                                <span class="sidebar-normal">Archivadores</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
       
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
                            <a @click="menu=10" href="javascript:void(0)" class="nav-link">
                                <span class="sidebar-mini">FN</span>
                                <span class="sidebar-normal">Funcionarios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        
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