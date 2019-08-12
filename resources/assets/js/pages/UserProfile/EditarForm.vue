<template>
    <div class="card card-wizard" id="wizardCard">
        <form-wizard shape="tab"
                    @on-complete="wizardComplete"
                    error-color="#FB404B"
                    color="#35495E"
                    :title="'Mi Curriculum'"
                    :subtitle="'subtitulo'">
                    
            <tab-content title="Datos Personales"
                        class="col-12"
                        icon="nc-icon nc-badge"> 

                <!-- :before-change="() => validate()"  / se debe escribir abajo de la propiedad class para validar los campos -->

                <!-- Alert de Información principal en el primer panel -->

                <!-- Nombres y Apellidos -->
                <div class="row">
                    <!-- Nombres -->
                    <div class="col-md-6">
                        <fg-input label="Nombres"
                                name="nombres"
                                autofocus
                                v-validate="modelValidations.nombres"
                                v-model="auth.nombres"
                                :error="getError('nombres')"
                                placeholder="Ej: Daniel Orlando">
                        </fg-input>
                    </div>
                    <!-- Apellidos -->
                    <div class="col-md-6">
                        <fg-input label="Apellidos"
                                name="apellidos"
                                v-validate="modelValidations.apellidos"
                                v-model="auth.apellidos"
                                :error="getError('apellidos')"
                                placeholder="Ej: Pérez González">
                        </fg-input>
                    </div>
                </div>

                <!-- Correo Electrónico -->
                <div class="row">
                    <div class="col-md-6">
                        <fg-input label="Email"
                                placeholder="Ej: correo@correo.cl"
                                type="email"
                                name="email"
                                v-validate="modelValidations.email"
                                :error="getError('email')"
                                v-model="auth.email">
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <fg-input label="Rut"
                                placeholder="Ej: 12345678-9"
                                name="rut"
                                v-validate="modelValidations.rut"
                                :error="getError('rut')"
                                v-model="auth.rut">
                        </fg-input>
                    </div>
                </div>

                <!-- Selects Región y Comuna -->
                <div class="row">
                    <!-- Select Región -->
                    <div class="col-md-6">
                        <label>Seleccione una Región</label>
                            <el-select class="select-default"
                                    size="large"
                                    name="region"
                                    v-validate="modelValidations.region"
                                    placeholder="Región"
                                    v-model="postulante.region"
                                    v-on:change="changeRegion($event)">
                                <el-option v-for="region in arrayRegiones"
                                        class="select-primary"
                                        :value="region.id"
                                        :label="region.nombre"
                                        :key="region.id">
                                </el-option>
                            </el-select>
                        <span class="text-danger size" v-text="getError('region')"></span>
                    </div>

                    <!-- Select Comuna -->
                    <div class="col-md-6">
                        <label>Seleccione una Comuna</label>
                            <el-select class="select-default"
                                        size="large"
                                        name="comuna"
                                        v-validate="modelValidations.comuna"
                                        placeholder="Comuna"
                                        v-model="postulante.comuna">
                                <el-option v-for="comuna in arrayComunas"
                                            class="select-primary"
                                            :value="comuna.id"
                                            :label="comuna.nombre"
                                            :key="comuna.id">
                                </el-option>
                            </el-select>
                        <span class="text-danger size" v-text="getError('comuna')"></span>
                    </div>
                </div>
                
                <br>

                <!-- Dirección -->
                <div class="row">
                    <div class="col-md-6">
                        <fg-input label="Dirección"
                                    placeholder="Ej: Vicuña Mackena 350"
                                    name="direccion"
                                    v-validate="modelValidations.direccion"
                                    :error="getError('direccion')"
                                    v-model="postulante.direccion">
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <fg-input label="Teléfono"
                                    placeholder="Ej: 912345678"
                                    name="telefono"
                                    v-validate="modelValidations.telefono"
                                    :error="getError('telefono')"
                                    v-model="postulante.telefono">
                        </fg-input>
                    </div>
                </div>
                    <br>
                <p class="banda text-center">IGUALDAD DE OPORTUNIDADES</p>

                <!-- Alert de información -->
                
                <l-alert type="info">
                    Esta plataforma fomenta la <strong> Igualdad de  Oportunidades </strong>
                    <br>
                    Tus respuestas en esta sección <strong>No afectarán tu evaluación</strong>, si no que aportarán a la <strong>Inclusión Laboral</strong>
                </l-alert>

                <!-- Genero -->

                <div class="row">
                    <div class="col-md-6">
                        <fg-input label="Género" :error="getError('genero')">
                        <br>
                            <div class="form-check form-inline">
                                <div class="col-md-6">
                                <radio name="genero" v-validate="modelValidations.genero" label="mujer" v-model="postulante.genero">Mujer </radio> 
                                </div>
                                <div class="col-md-6">
                                    <radio name="genero" v-validate="modelValidations.genero" label="hombre" v-model="postulante.genero">Hombre</radio>
                                </div>
                            </div>
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <fg-input label="Fecha de Nacimiento">
                            <el-date-picker v-model="postulante.fecha_nacimiento" 
                                            format="dd-MM-yyyy" 
                                            name="fecha_nacimiento"
                                            v-validate="modelValidations.fecha_nacimiento"
                                            type="date" 
                                            placeholder="dd-mm-yyyy">
                            </el-date-picker>
                            <span class="text-danger size" v-text="getError('fecha_nacimiento')"></span>
                        </fg-input>
                    </div>
                </div>

                <!-- Discapacidad -->

                <div class="row">
                    <div class="col-md-6">
                    <fg-input name="discapacidad" :error="getError('discapacidad')" label="¿Tienes alguna discapacidad certificada por el ministerio de salud?">
                        <br>
                        <div class="form-check form-inline">
                        <div class="col-md-6">
                            <radio v-validate="modelValidations.discapacidad" name="discapacidad" v-model="postulante.discapacidad" label="false">No</radio> 
                        </div>
                        <div class="col-md-6">
                            <radio v-validate="modelValidations.discapacidad" name="discapacidad" v-model="postulante.discapacidad" label="true" >Si</radio>
                        </div>
                        </div>
                    </fg-input>
                    </div>
                
                    <div v-show="postulante.discapacidad=='true'" class="col-md-6">
                        <fg-input label="¿Cuál?"
                                placeholder="Escriba aquí la discapacidad que posee"
                                name="discapacidad"
                                autofocus
                                v-validate="modelValidations.enfermedad"
                                :error="getError('discapacidad')"
                                v-model="postulante.enfermedad">
                        </fg-input>
                    </div>     
                </div>

                <!-- <first-step ref="firstStep" @on-validated="onStepValidated"></first-step> -->
            </tab-content>
        <!-- ------------------------------------- -->
            <tab-content title="Datos Profesionales"
                            class="col-12"
                            icon="nc-icon nc-notes">

                        <p class="banda text-center"><i class="fa fa-graduation-cap"></i> EDUCACIÓN 
                        <l-button @click="openModal('educacion', 'registrar')" size="sm" wide type="success" outline>
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Añadir
                        </l-button></p>

                        <div class="table-responsive">
                        <div class="card-body table-full-width">
                        <table class="table">
                            <thead>
                                <tr class="text-left">
                                    <th>#</th>
                                    <th>Titulo</th>
                                    <th>Grado</th>
                                    <th>Estado</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="(educacion, index) in JSON.parse(this.auth.educacion)" :key="index">
                                <tr class="text-left">
                                    <td class="category small" v-text="index+1"></td>
                                    <td class="category small" v-text="educacion.titulo"></td>
                                    <td class="category small" v-text="educacion.tipo_educacion"></td>
                                    <td class="category small" v-text="educacion.estado"></td>
                                    <td class="td-actions">
                                        <a href="#" @click.prevent="openModal('educacion', 'editar', educacion.id)" rel="tooltip" title="View Profile" class="btn btn-info btn-link btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="#" rel="tooltip" title="Edit Profile" class="btn btn-success btn-link btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-xs">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>  
                        </table>
                        </div>
                        </div>

                            <br>
                            <p class="banda text-center"><i class="fa fa-newspaper-o"></i> EXPERIENCIA LABORAL</p>

                            <div class="row">
                            <div class="col-md-6">
                                <fg-input label="ÚLTIMO CARGO"
                                        placeholder="Ej: Jefe de operaciones comerciales"
                                        name="direccion"
                                        :error="getError('direccion')"
                                        v-model="postulante.direccion">
                                </fg-input>
                            </div>
                            <div class="col-md-6">
                                <fg-input label="ÚLTIMA EMPRESA"
                                        placeholder="Ej: Cencosud"
                                        name="ultima_empresa"
                                        :error="getError('telefono')"
                                        v-model="postulante.telefono">
                                </fg-input>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                <fg-input label="CANTIDAD DE PERSONAS QUE HAS TENIDO A CARGO"
                                        placeholder="Ej:30"
                                        name="personas_cargo"
                                        type="number"
                                        :error="getError('personas_cargo')"
                                        v-model="postulante.personas_cargo">
                                </fg-input>
                            </div>
                            <div class="col-md-6">
                                <label>AÑOS DE EXPERIENCIA EN EL ÀREA</label>
                                <el-select class="select-default"
                                            size="large"
                                            name="experiencia"
                                            placeholder="1"
                                            v-model="postulante.experiencia">
                                    <el-option v-for="experiencia in selects.experiencia"
                                                class="select-primary"
                                                :value="experiencia.value"
                                                :label="experiencia.label"
                                                :key="experiencia.value">
                                    </el-option>
                                </el-select>
                                <span class="text-danger size" v-text="getError('experiencia')"></span>
                            </div>
                            </div>
                            <br>
                            <p class="banda text-center"><i class="fa fa-newspaper-o"></i> CONDICIONES</p>

                            <div class="row">
                                <div class="col-md-6">
                                <fg-input label="PRETENSIONES DE RENTA (Neta/Líquida Mensual CLP)"
                                        placeholder="Ej:1,500,000"
                                        name="pretensiones"
                                        type="number"
                                        :error="getError('pretensiones')"
                                        v-model="postulante.pretensiones">
                                </fg-input>
                            </div>
                            <div class="col-md-6">
                                <label>PERMISO LABORAL</label>
                                <el-select class="select-default"
                                            size="large"
                                            name="experiencia"
                                            placeholder="Chileno/a"
                                            v-model="postulante.experiencia">
                                    <el-option v-for="experiencia in selects.experiencia"
                                                class="select-primary"
                                                :value="experiencia.value"
                                                :label="experiencia.label"
                                                :key="experiencia.value">
                                    </el-option>
                                </el-select>
                                <span class="text-danger size" v-text="getError('experiencia')"></span>
                            </div>
                            </div>

                        <div v-show="postulante.preguntas_adicionales.length>0">
                            <br>
                            <p class="banda text-center"><i class="fa fa-newspaper-o"></i> PREGUNTAS ADICIONALES</p>

                            <div class="row">
                                <div v-for="(preguntas, index) in postulante.preguntas_adicionales" :key="index" class="col-md-6">
                                    <label v-text="preguntas.pregunta"></label>
                                    <fg-input
                                            placeholder="Ingresa una respuesta"
                                            name="respuestas"
                                            type="text"
                                            v-validate="modelValidations.respuestas"
                                            :error="getError('respuestas')"
                                            v-model="postulante.respuestas[index]">
                                    </fg-input>
                                </div>
                            </div>
                        </div>
                <!-- <second-step ref="secondStep"  @on-validated="onStepValidated"></second-step> -->
            </tab-content>

            <button slot="prev" class="btn btn-danger btn-fill btn-wd btn-back">Atrás</button>

            <button slot="next" class="btn btn-info btn-fill btn-wd btn-next">Continuar</button>

            <button slot="finish" @click="guardarPostulacion()" class="btn btn-success btn-fill btn-wd">Guardar</button>

        </form-wizard>   
    
    <div class="col-md-12">
      <el-dialog :visible.sync="modal">
        <span slot="title" class="dialog-title" v-text="tituloModal"></span>
        <form>
            <div v-if="tipoAccion == 1">
            <!-- Seleccionar un pais -->
                <div class="row">
                    <div class="col-md-6">
                    <label>Selecciona un País</label>
                        <el-select class="select-default"
                                    size="large"
                                    name="pais"
                                    placeholder="Pais"
                                    v-model="educacion.pais"
                                    v-on:change="changeRegion($event)"
                                    filterable>
                        <el-option v-for="pais in educacion.arrayPaises"
                                    class="select-primary"
                                    :value="pais.nombre"
                                    :label="pais.nombre"
                                    :key="pais.id">
                        </el-option>
                        </el-select>
                        <span class="text-danger size" v-text="getError('comuna')"></span>
                    </div>

                </div> 

                <!-- Seleccionar Tipo de Educacion y Estado -->

                <div class="row">
                    <div class="col-md-6">
                    <label>Tipo Educación</label>
                        <el-select class="select-default"
                                    size="large"
                                    name="tipo_educacion"
                                    placeholder="Seleccione"
                                    v-model="educacion.tipo_educacion">
                            <el-option v-for="tipo in selects.tipo_estudio"
                                        class="select-primary"
                                        :value="tipo.label"
                                        :label="tipo.label"
                                        :key="tipo.value">
                            </el-option>
                        </el-select>
                    <span class="text-danger size" v-text="getError('comuna')"></span>
                    </div>

                    <div class="col-md-6">
                    <label>Estado</label>
                        <el-select class="select-default"
                                    size="large"
                                    name="estado"
                                    placeholder="Seleccione"
                                    v-model="educacion.estado">
                            <el-option v-for="estado in selects.estado"
                                        class="select-primary"
                                        :value="estado.value"
                                        :label="estado.label"
                                        :key="estado.value">
                            </el-option>
                        </el-select>
                    <span class="text-danger size" v-text="getError('comuna')"></span>
                    </div>

                </div>

                <!-- Ingresar Titulo o carrera / Select Area de estudios -->

                <div class="row">
                    <div class="col-md-6">
                        <fg-input label="TITULO / CARRERA"
                                placeholder="Ingenieria en Informática"
                                name="titulo"
                                type="text"
                                :error="getError('pretensiones')"
                                v-model="educacion.titulo">
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <label>Área de Estudio</label>
                            <el-select class="select-default"
                                        size="large"
                                        name="area_estudio"
                                        placeholder="Seleccione"
                                        :search="true"
                                        v-model="educacion.area" filterable>
                                <el-option v-for="area in educacion.arrayAreas"
                                            class="select-primary"
                                            :value="area.id"
                                            :label="area.nombre"
                                            :key="area.id">
                                </el-option>
                            </el-select>
                        <span class="text-danger size" v-text="getError('comuna')"></span>
                    </div>
                </div> 

                <!-- Rango fechas de desarrollo de la carrera -->

                <div class="row">
                    <div class="col-md-12">
                        <label>Inicio / Fin</label>
                        <fg-input>
                            <el-date-picker
                                v-model="educacion.anos_estudios"
                                format="dd-MM-yyyy" 
                                type="daterange"
                                placeholder="Datetime picker here">
                            </el-date-picker>
                        </fg-input>
                    </div>
                </div>

                <!-- Seleccionar Institución -->

                <div class="row">
                    <div class="col-md-12">
                        <label>Institución</label>
                        <el-select class="select-default"
                                    size="large"
                                    name="institucion"
                                    placeholder="Seleccione"
                                    :search="true"
                                    v-model="educacion.institucion" filterable>
                            <el-option v-for="institucion in educacion.arrayInstituciones"
                                        class="select-primary"
                                        :value="institucion.id"
                                        :label="institucion.nombre"
                                        :key="institucion.id">
                            </el-option>
                        </el-select>
                    </div>
                </div>

            </div> 

        </form>

        <!-- Botones del Modal -->
        <span slot="footer" class="dialog-footer">
          <button class="btn btn-danger" @click="closeModal()">Cancel</button>&nbsp;
          <button class="btn btn-success" v-if="tipoAccion == 1" @click="addEducacion()">Guardar</button>
          <button class="btn btn-primary" v-if="tipoAccion == 2" @click="actualizarEmpresa()">Actualizar</button>
          <button class="btn btn-info" v-if="tipoAccion == 3" @click="AgregarSucursal()">Agregar Sucursal</button>
          <button class="btn btn-info" v-if="tipoAccion == 4" @click="AgregarCargos()">Agregar Cargos</button>
        </span>

      </el-dialog>
    </div>

    </div>

    

</template>
<script>

import {Dialog, DatePicker,  Table, TableColumn,Select, Option} from 'element-ui'
import LAlert from '@/components/Alert';
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import {
        Progress as LProgress,
        Switch as LSwitch,
        Radio,
        FormGroupInput as FgInput,
        Checkbox 
    } from '@/components/index'

  export default {
      props: [
        'auth'
    ],
    components: {
      [Dialog.name]: Dialog,
      LSwitch,
      [DatePicker.name]: DatePicker,
      [Select.name]: Select,
      [Option.name]: Option,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      Checkbox,
      FormWizard,
      TabContent,
      LAlert,
      Radio,
    },
    data () {
      return {
        modal: false,
        tituloModal: '',
        tipoAccion:0,
        educacion:{
            arrayPaises:[],
            arrayInstituciones:[],
            arrayAreas:[],
            arrayTipoEducacion:[],
            area:'',
            institucion:'',
            pais:'',
            tipo_educacion:'',
            estado:'',
            titulo:'',
            anos_estudios:'',
            arrayEducacion:[],
            educacion:'',
        },
        postulante: {
            nombres: '',
            apellidos: '',
            email: '',
            telefono: '',
            comuna: '',
            direccion: '',
            rut: '',
            genero: '',
            fecha_nacimiento: '',
            discapacidad: '',
            region: '',
            enfermedad: '',
            titulado: false,
            ano_titulacion: '',
            nivel_educacional:'',
            personas_cargo: '',
            experiencia: '',
            preguntas_adicionales: [],
            respuestas : []
        },
        modelValidations: {
            nombres: {
                required: true,
            },
            apellidos: {
                required: true,
                min: 5
            },
            email: {
                required: true,
                email: true
            },
            telefono: {
                required: true,
                numeric: true,
                min:8
            },
            comuna: {
                required: true,
            },
            direccion: {
                required: true,
            },
            rut: {
                required: true,
            },
            genero: {
                required: true,
            },
            fecha_nacimiento: {
                required: true,
            },
            discapacidad: {
                required: true,
            },
            region: {
                required: true,
            },
            discapacidad: {
                required: true,
            },
            respuestas: {
                required: true,
            }
        },
        selects     : {
            simple    : '',
            tipos : [
                {value: 'Full-time', label: 'Full-time'},
                {value: 'Part-time', label: 'Part-time'},
                {value: 'Part-time & Full-time', label: 'Part-time & Full-time'},
            ],
            estado : [
                {value: 'En Curso', label: 'En Curso'},
                {value: 'Graduado', label: 'Graduado'},
                {value: 'Abandonado', label: 'Abandonado'},
            ],
            tipo_estudio : [
                {value: 'Secundario', label: 'Secundario'},
                {value: 'Terciario', label: 'Terciario'},
                {value: 'Universitario', label: 'Universitario'},
                {value: 'Posgrado', label: 'Posgrado'},
                {value: 'Master', label: 'Master'},
                {value: 'Doctorado', label: 'Doctorado'},
                {value: 'Otro', label: 'Otro'},
            ],
            experiencia : [
                {value: '1', label: '1'},
                {value: '2', label: '2'},
                {value: '3', label: '3'},
                {value: '4', label: '4'},
                {value: '5+', label: '5+'},
            ],
        },
        arrayRegiones  : [],
        arrayComunas   : [],        
        datosUserAuth:[]
      }
    },
    methods: {
        addEducacion: function(){
            var educacion = JSON.parse(this.auth.educacion);
            var educaciones = this.educacion.arrayEducacion;
            educacion.push({"tipo_educacion": this.educacion.tipo_educacion, "titulo": this.educacion.titulo, "estado":this.educacion.estado, "pais": this.educacion.pais, "tipo_educacion": this.educacion.tipo_educacion})
            educacion.forEach((ob,item)=>this.$set(ob, 'id', Number(item+(1))));
            this.educacion.pais=''
            this.auth.educacion = JSON.stringify(educacion);
        },

        editarEducacion: function(id){
            $.each(JSON.parse(this.auth.educacion), function(key, value) {
                if(value.id == id){

                    this.tipoAccion   = 1;
                    console.log(this.modal)
                }
            });
        },

        openModal (modelo, accion, data = []) {
            switch(modelo){
                case 'educacion': 
                    switch(accion){
                        case 'registrar':
                            this.clearError()
                            this.errores      = [],
                            this.modal        = true;
                            this.tituloModal  = 'REGISTRAR EDUCACIÓN';
                            this.tipoAccion   = 1;
                        break;
                        case 'editar':
                            this.clearError()
                            console.log(data)
                            this.errores      = [],
                            this.modal        = true;
                            this.tituloModal  = 'REGISTRAR EDUCACIÓN';
                            this.tipoAccion   = 1;
                        break;
                        case 'actualizar': 
                        break;
                    }
            }
        },
        updateProfile () {
            alert('Your data: ' + JSON.stringify(this.user))
        },
        wizardComplete () {
            // swal('Good job!', 'You clicked the finish button!', 'success')
         },
        getError (fieldName) {
            return this.errors.first(fieldName)
        },
        selectPais(){
            let me = this;
            var url = 'paises/selectPais/';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.educacion.arrayPaises = respuesta.paises;
            }).catch(function (error) {
                console.log(error);
            })
        },
        selectInstitucion(){
            let me = this;
            var url = 'instituciones/selectInstitucion/';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.educacion.arrayInstituciones = respuesta.instituciones;
            }).catch(function (error) {
                console.log(error);
            })
        },
        selectArea(){
            let me = this;
            var url = 'areas/selectArea/';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.educacion.arrayAreas = respuesta.areas;
            }).catch(function (error) {
                console.log(error);
            })
        },
        selectRegion(){
            let me = this;
            var url = 'regiones/selectRegion/';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayRegiones = respuesta.regiones;
            }).catch(function (error) {
                console.log(error);
            })
        },
        changeRegion(id){
            let me = this;
            me.arrayComunas = [];
            me.comuna = '';
            var url = 'comunas/selectComuna/'+id;
            axios.get(url).then(function (response) {
            var respuesta = response.data;
            //Obtiene las comunas de la regiona seleccionada
            me.arrayComunas = respuesta.comunas;
            }).catch(function (error) {
            console.log(error);
            })
        },
        clearError(){
            this.$validator.reset();
        },
        },
    mounted(){
        this.selectRegion()
        this.selectPais()
        this.selectArea()
        this.selectInstitucion()
        // this.vacante.empresa      = this.vacante.privacidad=="no"?this.vacante.empresa+' - ': "";
        // this.postulante.preguntas_adicionales = JSON.parse(this.vacante.preguntas)

        this.$validator.localize('en', {
        messages: {
            required: (field) => '* ' + field + ' es requerido',
            min: (field) => '* ' + field + ' debe tener un minimo de caracteres',
            numeric: (field) => '* ' + field + ' debe tener sólo números',
            email: (field) => '* ' + field + ' tiene un formato incorrecto',
        },
        attributes: {
            respuestas: 'Respuestas adicionales'
        } 
        })
    },

  }

</script>
<style>
    .form-group {
        margin-bottom: 0rem;
    }
</style>
