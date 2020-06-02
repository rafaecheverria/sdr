<template>
    <div class="col-md-12">
        <div>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-12">
                    <div class="card card-wizard" id="wizardCard">
                        <form-wizard shape="tab"
                                    @on-complete="wizardComplete"
                                    error-color="#FB404B"
                                    color="#35495E"
                                    :title="vacante.cargo"
                                    :subtitle="vacante.empresa+'Publicado el '+ format_fecha(vacante.fecha_creado)">
                                    
                        <tab-content title="Datos Personales"
                                    class="col-12"
                                    icon="nc-icon nc-badge"> 

                            <!-- :before-change="() => validate()"  / se debe escribir abajo de la propiedad class para validar los campos -->

                            <!-- Alert de Información principal en el primer panel -->
                            <l-alert type="info" icon="nc-icon nc-bell-55">

                                <strong>Bienvenido a la primera etapa...</strong> en esta parte del proceso le pediremos que nos 
                                entregue información para conocer su <strong>Perfil cognitivo y laboral</strong>; Estos datos son confidenciales
                                y solo lo tendran acceso a ellos los miembros de la empresa a la que usted esta postulando.

                            </l-alert>

                            <!-- Nombres y Apellidos -->
                            <div class="row">
                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <fg-input label="Nombres"
                                            name="nombres"
                                            autofocus
                                            v-validate="modelValidations.nombres"
                                            v-model="postulante.nombres"
                                            :error="getError('nombres')"
                                            placeholder="Ej: Daniel Orlando">
                                    </fg-input>
                                </div>
                                <!-- Apellidos -->
                                <div class="col-md-6">
                                    <fg-input label="Apellidos"
                                            name="apellidos"
                                            v-validate="modelValidations.apellidos"
                                            v-model="postulante.apellidos"
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
                                            v-model="postulante.email">
                                    </fg-input>
                                </div>
                                <div class="col-md-6">
                                    <fg-input label="Rut"
                                            placeholder="Ej: 12345678-9"
                                            name="rut"
                                            v-validate="modelValidations.rut"
                                            :error="getError('rut')"
                                            v-model="postulante.rut">
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
                                        <div class="form-check form-check-inline">
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
                                    <div class="form-check form-check-inline">
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

                                    <p class="banda text-center"><i class="fa fa-graduation-cap"></i> EDUCACIÓN</p>

                                    <div class="row">
                                        <div class="col-md-6">
                                        <label>Nivel Educacional</label>
                                        <el-select class="select-default"
                                                        size="large"
                                                        name="empresa"
                                                        placeholder="Ej: Educación Superior"
                                                        v-model="postulante.nivel_educacional">
                                            <el-option v-for="regiones in arrayRegiones"
                                                        class="select-primary"
                                                        :value="regiones.id"
                                                        :label="regiones.nombre"
                                                        :key="regiones.id">
                                            </el-option>
                                            </el-select>
                                            <span class="text-danger size" v-text="getError('comuna')"></span>
                                        </div>

                                        <div class="col-md-2">
                                        <p class="category">TITULADO</p>
                                        <l-switch name="titulado" v-model="postulante.titulado" type="primary" on-text="SI" off-text="NO"></l-switch>
                                        </div>

                                        <div class="col-md-4" v-show="postulante.titulado==true">
                                        <!-- <p class="category">Titulado</p>
                                        <l-switch name="titulado" v-model="postulante.titulado" type="primary" on-text="SI" off-text="NO"></l-switch> -->
                                        <fg-input label="Año de titulación"
                                                    placeholder="Ej: 2010"
                                                    name="ano_titulacion"
                                                    type="number"
                                                    autofocus
                                                    v-model="postulante.ano_titulacion">
                                        </fg-input>
                                        </div>
                                        <!-- v-show="postulante.titulado==true" -->
                                        <!-- <div class="col-md-3">
                                        
                                        </div>   -->

                                        </div>
                                        <br>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <label>ÁREA TITULO PROFESIONAL PREGRADO</label>
                                                <el-select class="select-default"
                                                        size="large"
                                                        name="region"
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
                                        <div class="col-md-6">
                                            <label>PROFESIÓN</label>
                                            <el-select class="select-default"
                                                        size="large"
                                                        name="profesion"
                                                        placeholder="Ej: Ingeniero en telecomunicaciones"
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

                                        <div class="row">
                                        <div class="col-md-6">
                                            <label>TIPO DE INSTITUCIÓN EDUCATIVA</label>
                                                <el-select class="select-default"
                                                        size="large"
                                                        name="institucion"
                                                        placeholder="Ej: Universidad"
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
                                        <div class="col-md-6">
                                            <label>UNIVERSIDAD/INSTITUTO</label>
                                            <el-select class="select-default"
                                                        size="large"
                                                        name="comuna"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import bus from '@/event-bus'
    import {DatePicker, Select, Option} from 'element-ui'
    import LAlert from '@/components/Alert';
    import moment from 'moment'
    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    
    import {
        Progress as LProgress,
        Switch as LSwitch,
        Radio,
        FormGroupInput as FgInput,
        Checkbox 
    } from '@/components/index'

    moment.locale('es')

export default {
    props: [
        'vacante'
    ],
    components: {
      LSwitch,
      [DatePicker.name]: DatePicker,
      [Select.name]: Select,
      [Option.name]: Option,
      Checkbox,
      FormWizard,
      TabContent,
      LAlert,
      Radio,
    },
    data () {
        return {
            cargo:'',
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
        }
    },
       
    methods:{
        format_fecha: function(d){
            return moment(d).format("dddd, D MMMM YYYY, h:mm:ss a");
        },
        wizardComplete () {
            // swal('Good job!', 'You clicked the finish button!', 'success')
        },
        getError (fieldName) {
            return this.errors.first(fieldName)
        },
        selectRegion(){
            let me = this;
            var url = '/api/regiones/selectRegion/';
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
            var url = '/api/comunas/selectComuna/'+id;
            axios.get(url).then(function (response) {
            var respuesta = response.data;
            //Obtiene las comunas de la regiona seleccionada
            me.arrayComunas = respuesta.comunas;
            }).catch(function (error) {
            console.log(error);
            })
        },
        guardarPostulacion () {
            this.validate()
            var final = [];
            var preguntas_adicionales = this.postulante.preguntas_adicionales;
            var respuestas = this.postulante.respuestas;
            for(var i = 0; i < preguntas_adicionales.length; i++){
                // console.log(respuestas[i])       
                final.push({ pregunta : preguntas_adicionales[i].pregunta, tipo: preguntas_adicionales[i].tipo, respuesta: respuestas[i] })    
            }
            console.log(final)
    
        },
        validate () {
            return this.$validator.validateAll().then(res => {
            this.$emit('on-validated', res, this.model)
            return res  
            })
      },
    },

     mounted(){
        this.selectRegion()
        this.vacante.empresa      = this.vacante.privacidad=="no"?this.vacante.empresa+' - ': "";
        this.postulante.preguntas_adicionales = JSON.parse(this.vacante.preguntas)

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
