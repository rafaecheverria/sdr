<template>
  <div>
    <notifications></notifications>
          <!-- <fade-render-transition :duration="100"> -->
            <div v-if="vista == 1">
    <card>

      <div slot="header">
        <span class="card-title font-weight-normal font-weight-light text-white small text-white">LISTA DE DOCUMENTOS</span>
      </div>
      <br>

      <div class="row">
        <div class="col-md-3">
          <el-select class="select-primary"
                      size="large"
                      placeholder="Buscar por:"
                      v-model="criterio">
            <el-option v-for="option in selects.criterios"
                        class="select-primary"
                        :value="option.value"
                        :label="option.label"
                        :key="option.label">
            </el-option>
          </el-select>
        </div>
          <div class="col-md-3 padd">
            <fg-input placeholder="Buscar" v-model="buscar" @keyup.enter="listarUsuarios(1, buscar, criterio)"></fg-input>
          </div>
          <div class="col-md-3">
            <l-button type="info" outline wide @click="listarDocumentos(1, buscar, criterio)">
                <span class="btn-label">
                    <i class="fa fa-search"></i>
                </span>
                Buscar
              </l-button>
          </div>

          <div class="col-md-3">
            <l-button type="success" outline wide  @click="openModal('documento', 'registrar')">
                <span class="btn-label">
                    <i class="fa fa-plus"></i>
                </span>
              </l-button>
          </div>

        </div>
        <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <el-table stripe style="width: 100%;" :data="tablaDocumentos">
              <el-table-column prop="numero_documento" minWidth= 60 label="Nº"></el-table-column>

              <el-table-column prop="remitente" 
                               minWidth= 250 
                               label="Firma/Remitente">
              </el-table-column>


               <el-table-column minWidth= 100 label="Origen">
                <template slot-scope="{row}">
                    
                      <span v-tooltip.top-center="row.origen">{{row.osiglas}}</span>

                  </template>
              </el-table-column>
              <el-table-column minWidth= 100 label="Destino">
                <template slot-scope="{row}">
                    
                      <span v-tooltip.top-center="row.destino">{{row.dsiglas}}</span>

                  </template>
              </el-table-column>
              <el-table-column  minWidth= 120 label="Fecha">

                  <template slot-scope="{row}">
                    
                      <span format="DD-MM-YYYY">{{format_fecha(row.fecha)}}</span>

                  </template>

               </el-table-column>
               <el-table-column prop="tipo" minWidth= 100 label="Tipo"></el-table-column>
               <el-table-column minWidth= 120 label="Estado">
                 <template slot-scope="{row}">

                   <!-- MIENTRAS EL DOCUMENTO NO ESTE ARCHIVADO (ESTADO 3) Y EL DESTINO SEA DISTINTO AL DEPTO DEL USER EN SESIÒN SE MOSTRARÀ EL ESTADO DERIVADO -->
                  <div v-if="row.auth_depto_id != row.destino_actual && row.estado_id != 3">

                    <span  class="badge badge-info text-white">{{"DERIVADO".toUpperCase()}}</span>

                  </div>

                  <div v-else>
                  
                    <span v-if="row.estado_id === 1" class="badge badge-warning text-white">{{row.estado.toUpperCase()}}</span>

                    <span v-if="row.estado_id === 2" class="badge badge-danger text-white">{{row.estado.toUpperCase()}}</span>
                  
                    <span v-if="row.estado_id === 3" class="badge badge-success text-white">{{row.estado.toUpperCase()}}</span>
                    
                  </div>

                </template>

                </el-table-column>

                <el-table-column :min-width="190" fixed="right">

                  <template slot-scope="props">
                    
                    <!-- EL BOTÒN RECIBIR SE MOSTRARÀ CUANDO ES ESTADO SEA 2 (POR RECIBIR) Y EL DEPTO DEL USER EN SESIÒN SEA IGUAL AL DESTINO -->
                    <a v-if="props.row.estado_id == 2 && 
                             props.row.auth_depto_id === props.row.destino_actual" 
                            @click="openModal('documento', 'recibir', props.row.id)" 
                            v-tooltip.top-center="'Recibir'" 
                            style="color:#d8592d" 
                            class="btn-primary btn-simple btn-link">
                            <i class="fa fa-check"></i>
                    </a>

                    <a v-tooltip.top-center="'Ver'" 
                       @click="verDocuemento(props.row.id)"
                       style="color:#881b96"
                      class=" btn-simple btn-link">
                      <i class="fa fa-eye"></i>
                    </a>

                    <a v-if="props.row.estado_id != 2 &&
                             props.row.estado_id === 1 && 
                             props.row.auth_depto_id === props.row.destino_actual" 
                             v-tooltip.top-center="'Derivar'" 
                             @click="openModal('documento', 'derivar', props.row.id)" 
                             class="btn-success btn-simple btn-link">
                             <i class="fa fa-share"></i>
                    </a>
                    <!-- EL BOTÒN ARCHIVAR DIGITAL SE MOSTRARÀ CUANDO EL DOCUMENTO ESTA EN PROCESO DEL DESTINATARIO -->
                    <a v-if="props.row.estado_id != 2 && 
                       props.row.estado_id === 1 && 
                       props.row.auth_depto_id === props.row.destino_actual" 
                       v-tooltip.top-center="'Archivar'" 
                       style="color:#2d32d8" 
                       class="btn-simple btn-link"
                       @click="openModal('documento', 'archivar', props.row)">
                       <i class="fa fa-folder"></i>
                    </a>

                    <!-- EL BOTÒN ARCHIVO DIGITAL SE MOSTRARÀ SOLO CUANDO EXISTA UN DOCUMENTO CARGADO EN EL CAMPO ARCHIVO DE LA BASE DE DATOS -->
                    <a v-tooltip.top-center="'Archivo Digital'" 
                       class="btn-info btn-simple btn-link"
                       @click="openModal('usuario', 'roles', props.row)">
                       <i class="fa fa-paperclip"></i>
                    </a>

                    <!-- EL BOTÒN EDITAR DOCUMENTO SE ACTIVARÀ SOLO PARA EL CREADOR DEL DOCUMENTO Y CUANDO EL DOCUMENTO NO ESTE ARCHIVADO -->
                    <a v-if="props.row.auth_depto_id === props.row.creador && props.row.estado_id != 3" 
                       v-tooltip.top-center="'Editar'" 
                       class="btn-warning btn-simple btn-link"
                       @click="openModal('usuario', 'actualizar', props.row)"> 
                       <i class="fa fa-edit"></i>
                    </a>

                    <!-- EL BOTÒN ELIMINAR DERIVACIÒN SE ACTIVARÀ CUANDO EL DOCUMENTO FUE DERIBADO PERO AUN NO HA SIDO RECEPCIONADO POR EL DESTINATARIO -->
                    <a v-if="props.row.auth_depto_id === props.row.origen_id && props.row.estado_id == 2" 
                       v-tooltip.top-center="'Eliminar derivación'"
                       @click="desDerivar(props.row.id)" class="btn-danger btn-simple btn-link">
                       <i class="fa fa-reply-all"></i> 
                    </a>

                    <!-- ICONO DES-ARCHIVAR SE MOSTRARÁ SOLO AL DEPARTAMENTO QUE LO ARCHIVÓ-->
                    <a v-if="props.row.auth_depto_id === props.row.destino_actual && props.row.estado_id == 3"
                       v-tooltip.top-center="'Des-Archivar'" 
                       @click="desArchivar(props.row.id)" 
                       class="btn-danger btn-simple btn-link">
                       <i class="fa fa-folder-open"></i>
                       <!-- fa fa-folder-open -->
                    </a>

                    <!-- EL BOTÒN ELIMINAR DERIVACIÒN SE ACTIVARÀ CUANDO EL DOCUMENTO FUE DERIBADO PERO AUN NO HA SIDO RECEPCIONADO POR EL DESTINATARIO -->
                    <a v-tooltip.top-center="'Descargar Documento'"
                       @click="descargarDocumento(props.row.id)" class="btn-success btn-simple btn-link">
                       <i class="fa fa-download"></i> 
                    </a>

                    <!-- EL BOTÒN ELIMINAR DOCUMENTO SE ACTIVARÀ SOLO PARA EL CREADOR DEL DOCUMENTO -->
                    <!-- <a v-if="props.row.auth_depto_id === props.row.creador" 
                       v-tooltip.top-center="'Eliminar documento'" 
                       @click="desDerivar(props.row.id)" 
                       class="btn-danger btn-simple btn-link">
                       <i class="fa fa-times"></i>
                    </a> -->

                  </template>

                </el-table-column>

            </el-table>

          </div>

          <!-- Paginacion -->
          <div class="card-body">
            <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">«</a>
                  </li>
                   <li class="page-item disabled" v-else>
                      <a class="page-link" disabled="disabled">«</a>
                  </li>
                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                  </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">»</a>
                  </li>
                   <li class="page-item disabled" v-else>
                      <a class="page-link" disabled="disabled">»</a>
                  </li>
              </ul>
            </div>
          </div>
          
      </div>

    </card>

                  <!-- Lista Principal de las vacantes -->

      <div class="row">

        <div class="col-md-12" v-for="datos in tablaDocumentos" :key="datos.id">

          <card class="border-danger">


              <div slot="header">
              

              <div class="row">

                <div class="col-md-9">

                  <span class="card-title font-weight-normal font-weight-light text-white small text-white" v-html="'<b>'+datos.remitente+'</b>'+', '+ datos.cargo +', '+datos.origen+', '+datos.region_origen"></span>

                    <p class="card-category text-white" v-text="datos.asunto"></p>

                </div>

                <div class="col-md-3 text-right">

                  <p class="card-category text-white" v-text="'Creado el 03-03-2020'"></p>  

                </div>

              </div>

            </div>
          
          <br>

          <div class="col-md-12 tamano-text" v-text="datos.detalle.replace(/(<([^>]+)>)/ig,'')"></div>

          <hr size="3" />

            <div class="card-footer"> 
      
              <div class="row">

                <div class="col-md-8 col-sm-12">

                  <i class="fa fa-map-marker text-danger"></i> <span class="card-category" v-text="'comuna y region'"></span>


                  <i class="fa fa-clock-o text-primary"></i> <span class="card-category" v-text="'tipo trabajo'"></span>

                   <!-- MIENTRAS EL DOCUMENTO NO ESTE ARCHIVADO (ESTADO 3) Y EL DESTINO SEA DISTINTO AL DEPTO DEL USER EN SESIÒN SE MOSTRARÀ EL ESTADO DERIVADO -->
                  <div v-if="datos.auth_depto_id != datos.destino_actual && datos.estado_id != 3">

                    <!-- <span  class="badge badge-info text-white">{{"DERIVADO".toUpperCase()}}</span> -->
                    <i class="fa fa-circle text-info"></i> <span class="card-category" v-text="'Derivado'"></span>

                  </div>

                  <div v-else>
                  
                    <span v-if="datos.estado_id === 1" class="badge badge-warning text-white">{{datos.estado.toUpperCase()}}</span>

                    <span v-if="datos.estado_id === 2" class="badge badge-danger text-white">{{datos.estado.toUpperCase()}}</span>
                  
                    <span v-if="datos.estado_id === 3" class="badge badge-success text-white">{{datos.estado.toUpperCase()}}</span>
                    
                  </div>

                  <!-- <i class="fa fa-circle text-success"></i> <span class="card-category" v-text="datos.estado"></span> -->

                </div>

                <div class="col-md-4 col-sm-12 text-right">

                  <!-- EL BOTÒN RECIBIR SE MOSTRARÀ CUANDO ES ESTADO SEA 2 (POR RECIBIR) Y EL DEPTO DEL USER EN SESIÒN SEA IGUAL AL DESTINO -->
                    <a v-if="datos.estado_id == 2 && 
                             datos.auth_depto_id === datos.destino_actual" 
                            @click="openModal('documento', 'recibir', datos.id)" 
                            v-tooltip.top-center="'Recibir'" 
                            style="color:#d8592d" 
                            class="btn-primary btn-simple btn-link">
                            <i class="fa fa-check"></i>
                    </a>

                    <a v-tooltip.top-center="'Ver'" 
                       @click="verDocuemento(datos.id)"
                       style="color:#881b96"
                      class=" btn-simple btn-link">
                      <i class="fa fa-eye"></i>
                    </a>

                    <a v-if="datos.estado_id != 2 &&
                             datos.estado_id === 1 && 
                             datos.auth_depto_id === datos.destino_actual" 
                             v-tooltip.top-center="'Derivar'" 
                             @click="openModal('documento', 'derivar', datos.id)" 
                             class="btn-simple btn-link"
                             style="color:#de15c9">
                             <i class="fa fa-share"></i>
                    </a>

                    <!-- EL BOTÒN ARCHIVAR DIGITAL SE MOSTRARÀ CUANDO EL DOCUMENTO ESTA EN PROCESO DEL DESTINATARIO -->
                    <a v-if="datos.estado_id != 2 && 
                       datos.estado_id === 1 && 
                       datos.auth_depto_id === datos.destino_actual" 
                       v-tooltip.top-center="'Archivar'" 
                       style="color:#2d32d8" 
                       class="btn-simple btn-link"
                       @click="openModal('documento', 'archivar', datos)">
                       <i class="fa fa-folder"></i>
                    </a>

                    <!-- EL BOTÒN ARCHIVO DIGITAL SE MOSTRARÀ SOLO CUANDO EXISTA UN DOCUMENTO CARGADO EN EL CAMPO ARCHIVO DE LA BASE DE DATOS -->
                    <a v-tooltip.top-center="'Archivo Digital'" 
                       class="btn-info btn-simple btn-link"
                       style="color:#38D0F0"
                       @click="openModal('usuario', 'roles', datos)">
                       <i class="fa fa-paperclip"></i>
                    </a>

                    <!-- EL BOTÒN EDITAR DOCUMENTO SE ACTIVARÀ SOLO PARA EL CREADOR DEL DOCUMENTO Y CUANDO EL DOCUMENTO NO ESTE ARCHIVADO -->
                    <a v-if="datos.auth_depto_id === datos.creador && datos.estado_id != 3" 
                       v-tooltip.top-center="'Editar'" 
                       class="btn-warning btn-simple btn-link"
                       @click="openModal('usuario', 'actualizar', datos)"> 
                       <i class="fa fa-edit"></i>
                    </a>

                    <!-- EL BOTÒN ELIMINAR DERIVACIÒN SE ACTIVARÀ CUANDO EL DOCUMENTO FUE DERIBADO PERO AUN NO HA SIDO RECEPCIONADO POR EL DESTINATARIO -->
                    <a v-if="datos.auth_depto_id === datos.origen_id && datos.estado_id == 2" 
                       v-tooltip.top-center="'Eliminar derivación'"
                       @click="desDerivar(datos.id)" class="btn-danger btn-simple btn-link">
                       <i class="fa fa-reply-all"></i> 
                    </a>

                    <!-- ICONO DES-ARCHIVAR SE MOSTRARÁ SOLO AL DEPARTAMENTO QUE LO ARCHIVÓ-->
                    <a v-if="datos.auth_depto_id === datos.destino_actual && datos.estado_id == 3"
                       v-tooltip.top-center="'Des-Archivar'" 
                       @click="desArchivar(datos.id)" 
                       class="btn-danger btn-simple btn-link"
                       style="color:#e81632">
                       <i class="fa fa-folder-open"></i>
                       <!-- fa fa-folder-open -->
                    </a>

                    <!-- EL BOTÒN ELIMINAR DERIVACIÒN SE ACTIVARÀ CUANDO EL DOCUMENTO FUE DERIBADO PERO AUN NO HA SIDO RECEPCIONADO POR EL DESTINATARIO -->
                    <a v-tooltip.top-center="'Descargar Documento'"
                       @click="descargarDocumento(datos.id)" 
                       class="btn-success btn-simple btn-link"
                       style="color:#87CB15">
                       <i class="fa fa-download"></i> 
                    </a>


                  <!-- <button class="btn btn-warning" @click="openModal('vacante', 'detalles', datos)">Ver Detalles</button>

                  <button class="btn btn-info" @click="abrirPostulacion(datos)">Postular</button> -->

                </div>

              </div>    

            </div>

          </card>

        </div>

      </div>



    </div>

  <!-- </fade-render-transition> -->

     <div v-if="vista == 2">

        <ver-documento :datos="datosDocumento"></ver-documento>

      </div>

    

    <!-- Dialog -->
    <div class="col-md-12">
      <el-dialog
              :visible.sync="modal">
        <span slot="title" class="dialog-title" v-text="tituloModal"></span>

        <form>
          <div v-if="tipoAccion == 1">
            <!-- SI EL USUARIO SELECCIONA EL BOTÓN DERIVAR, SE MUESTRA ESTA VENTANA MODAL -->
            <div class="row">


              <div class="col-md-3">
                  <label>Interno/Externo</label><br>
                  <l-switch v-model="tipo" type="primary" on-text="INT" off-text="EXT"></l-switch>
              </div>


               <div :class="[{'col-md-4': !tipo}]" v-show="tipo===false">
                <label>Región</label>
                <el-select class="select-default"
                        size="large"
                        placeholder="Seleccionar Región"
                        v-model="region"
                        v-on:change="changeRegion($event)">
                  <el-option v-for="region in arrayRegiones"
                          class="select-primary"
                          :value="region.id"
                          :label="region.nombre"
                          :key="region.id">
                  </el-option>
                </el-select>
              </div>


               <!-- SI EL DOCUMENTO ES INTERNO, SE CARGARÁN LOS DEPARTAMENTOS A LOS QUE PERTENECE EL USUARIO EN SESIÓMN -->

            <div v-if="tipo == true" class="col-md-9">
             <label>Departamento/JI Infantil</label>
              <el-select class="select-default"
                        size="large"
                        placeholder="Seleccione Departamento"
                        v-model="departamento">
                <el-option v-for="departamento in arrayDepartamentosUsu"
                        class="select-primary"
                        :value="departamento.id"
                        :label="departamento.departamento"
                        :key="departamento.id">
                </el-option>
              </el-select>
            </div>

           <!-- SI EL DOCUMENTO ES EXTERNO, SE CARGARÁN LOS DEPARTAMENTOS SEGÚN LA REGIÓN SELECCIONADA8 -->

          <div v-else :class="[{'col-md-5': !tipo}]">
             <label>Departamento/JI Infantil</label>
          <el-select class="select-default"
                     size="large"
                     placeholder="Seleccione Departamento"
                     v-model="departamento">
            <el-option v-for="departamento in arrayDepartamentos"
                     class="select-primary"
                     :value="departamento.id"
                     :label="departamento.departamento"
                     :key="departamento.id">
            </el-option>
          </el-select>
          </div>

        </div>
      <br>
          </div>
          <!-- SI EL USUARIO SELECCIONA EL BOTÓN ARCHIVAR, SE MUESTRA ESTA VENTANA MODAL -->
          <div v-if="tipoAccion == 2">
            <div class="row">
              <div class="col-md-12">
                <label>Archivador</label>
                  <el-select class="select-default"
                          size="large"
                          placeholder="Seleccionar"
                          :search="true"
                          v-model="archivador" filterable>
                  <el-option v-for="(archivador, index) in arrayArchivador" :key="index"
                              class="select-primary"
                              :value="archivador.id"
                              :label="archivador.archivador"
                              >
                  </el-option>
                </el-select>
              </div>
            </div>

            <br>
        </div>
            <div class="row">
              <div class="col-md-12">
                <fg-input label="Proveido">
                  <el-input type="textarea"
                            class="default"
                            :rows="5"
                            v-model="documento.proveido"
                            placeholder="Escriba aqui el movimiento que le dará al documento.">
                  </el-input>
                </fg-input>
              
              </div>
            </div>
        </form>
        <!-- BOTONES DEL MODAL -->
        <span slot="footer" class="dialog-footer">
          <button class="btn btn-danger" @click="closeModal()">Cancelar</button>&nbsp;
          <button class="btn btn-success" v-if="tipoAccion == 1" @click="derivarDocumento()">Derivar</button>
          <button class="btn btn-info" v-if="tipoAccion == 2" @click="archivarDocumento()">Archivar</button>
        </span>

      </el-dialog>
    </div>

  </div>
</template>
<script>
  import {Dialog, Table, TableColumn, Select, Option, Notification} from 'element-ui'
  import swal from 'sweetalert2'
  import LSwitch from '@/components/Switch.vue'
  import LPagination from '@/components/Pagination.vue'
  import VerDocumento from './VerDocumento.vue'
  import {
        FadeRenderTransition,
        Progress as LProgress,
        Radio,
        FormGroupInput as FgInput,
        Checkbox
    } from '@/components/index'

  import moment from 'moment'
  export default{
       props: [
        'auth',
    ],
    components: {
      LSwitch,
      [Dialog.name]: Dialog,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      LPagination,
      [Select.name]: Select,
      [Option.name]: Option,
      [Notification.name]: Notification,
      FadeRenderTransition
    },
    data () {
      return {
        modal    : false,
        documento:{
          id: 0,
          proveido: '',
        },
        tipo:true,
        vista: 1,
        departamento: '',
        archivador:'',
        readonly     : 0,
        telefono     :'',
        tituloModal  : '',
        tablaDocumentos    : [],
        region             :'',
        tipoAccion   : 0,
        pagination   :{
          'total'        : 0,
          'current_page' : 0,
          'per_page'     : 0,
          'last_page'    : 0,
          'from'         : 0,
          'to'           : 0,
        },
        offset : 4,
        criterio : 'nombres',
        buscar : '',
        selects: {
          simple: '',
          criterios: [
            {value: 'nombre', label: 'Nombre'},
          ],
        },
        errores: [],
        arrayRoles: [],
        roles: [],
        arrayDepartamentos: [],
        arrayDepartamentosUsu: [],
        arrayArchivador: [],
        datosDocumento: [],
        arrayRegiones: [],
        id_documento:0
      }
    },
    computed: {

      isActived: function(){
        return this.pagination.current_page;
      },
      //Calcula los elementos de la paginación
      pagesNumber: function() {
          if(!this.pagination.to) {
              return [];
          }
          
          var from = this.pagination.current_page - this.offset; 
          if(from < 1) {
              from = 1;
          }

          var to = from + (this.offset * 2); 
          if(to >= this.pagination.last_page){
              to = this.pagination.last_page;
          }  

          var pagesArray = [];
          while(from <= to) {
              pagesArray.push(from);
              from++;
          }
          return pagesArray;             
      }

    },
    methods: {
      format_fecha: function(d){
          return moment(d).format('DD/MM/YYYY');
      },

      listarDocumentos(page, buscar, criterio){
        let me=this;
        var url = 'documentos?page='+ page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
          console.log(response.data)
          var respuesta = response.data;
          var final = [];
          for(var i = 0; i < respuesta.documentos.data.length; i++){
              final.push({  numero_documento : respuesta.documentos.data[i].numero_documento, 

                            remitente : respuesta.documentos.data[i].remitente_nombres+' '+ respuesta.documentos.data[i].remitente_apellidos,
                            dsiglas : respuesta.documentos.data[i].dsiglas,  //Trae la unidad de destino del documento   
                            osiglas : respuesta.documentos.data[i].osiglas,  //Trae la unidad de origen del documento    
                            tipo : respuesta.documentos.data[i].tipo, 
                            fecha : respuesta.documentos.data[i].fecha, 
                            auth_depto_id : me.auth.departamento_id, 
                            auth_id: me.auth.id,
                            id : respuesta.documentos.data[i].id, 
                            origen_id: respuesta.documentos.data[i].origen_id, 
                            estado: respuesta.documentos.data[i].estado,      
                            estado_id: respuesta.documentos.data[i].estado_id,  
                            destino_id: respuesta.documentos.data[i].destino_id,
                            destino_actual: respuesta.documentos.data[i].destino_actual,
                            creador: respuesta.documentos.data[i].creador,
                            asunto: respuesta.documentos.data[i].asunto,
                            detalle: respuesta.documentos.data[i].detalle,
                            origen: respuesta.documentos.data[i].origen,
                            cargo: respuesta.documentos.data[i].cargo,
                            region_origen: respuesta.documentos.data[i].region_origen,      
                        })    
          }
          me.tablaDocumentos = final;
          me.pagination = respuesta.pagination; 
          }).catch(function (error) {
          console.log(error);
        })
      },

      cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarDocumentos(page, buscar, criterio);
      },

      openModal (modelo, accion, data = []) {
        switch(modelo){
          case 'documento': 
            switch(accion){
              case 'recibir': 
                this.recibir(data)
              break;
              case 'derivar': 
                this.derivar(data)
              break;
              case 'archivar': 
                this.archivar(data)
              break;
              case 'registrar':
                this.arrayRoles = []
                this.errores= [],
                this.modal = true;
                this.nombre       = '';
                this.tituloModal  = 'Registrar Usuario';
                this.tipoAccion   = 1;
                this.readonly = 0;
              break;
              case 'actualizar': 
                this.arrayRoles = []
                this.errores= [];
                this.modal = true;
                this.tituloModal  = 'Actualizar Usuario';
                this.tipoAccion   = 2;
                this.nombre       = data['nombre'];
                this.readonly = 1;
                this.cargo_id   = data['id'];
              break;
            }
        }

      },

      recibir(data){
        swal({
          title: '¿Estas seguro?',
          text: `Si recibes este documento deberás atenderlo.`,
          type: 'question',
          showCancelButton: true,
          confirmButtonClass: 'btn btn-success btn-fill',
          cancelButtonClass: 'btn btn-danger btn-fill',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, atender',
          buttonsStyling: false
        }).then( result => {
          if (result.value) {
            let me = this;
              axios.post('documentos/recibir/'+data,{
              }).then(function(response){

                console.log(response)

                if(response.data.estado == false){
                   swal.fire({
                          type: 'warning',
                          title: 'Lo sentimos :(',
                          text: 'Usted ya no es el destinatario de este documento, contacte al origen del documento!',
                          showConfirmButton: true,
                        })

                }else{

                  swal({
                    title: 'Recibido!',
                    text: 'El documento ha sido recepcionado.',
                    type: 'success',
                    confirmButtonClass: 'btn btn-success btn-fill',
                    buttonsStyling: false
                  })

                }
                 
                  me.listarDocumentos(1,'','')
 
              }).catch(error => {
                if(error.response.status == 422){
                  me.errores = error.response.data.errors;
                }
              })

               
          }
        })
        
      },

      //SE EJECUTA CUANDO EL SELECT REGIÓN REALIZA UN CAMBIO  
      //AQUÍ SE CARGAN LOS DEPARTAMENTOS PERTENECIENTES A LA REGIÓN SELECCIONADA ANTERIORMENTE
      changeRegion(id){
            let me = this;
            me.arrayDepartamentos = [];
            me.departamento = '';
            var url = 'departamentos/selectDepartamentoReg/'+id;
            axios.get(url).then(function (response) {
            var respuesta = response.data;
            //Obtiene las comunas de la regiona seleccionada
            me.arrayDepartamentos = respuesta.departamentos;
            }).catch(function (error) {
            console.log(error);
            })
      },

      //CARGA TODAS LAS REGIONES AL SELECT REGIONES DEL FORMULARIO
      selectRegion(){
        let me = this;
        me.arrayRegiones = [];
        var url = '/regiones/selectRegion/';
        axios.get(url).then(function (response) {
          console.log(response.data)
            var respuesta = response.data;
            me.arrayRegiones = respuesta.regiones;
        }).catch(function (error) {
            console.log(error);
        })
      },

      //CARGA TODOS LOS DEPARTAMENTOS DE LA REGION A LA QUE PERTENECE EL USUARIO EN SESIÓN,
      //YA QUE SE HA SELECCIONADO UN DOCUMENTO INTERNO
      selectDepartamentoUsu(){
        let me = this;
        me.arrayDepartamentosUsu = [];
        var url = '/departamentos/selectDepartamento/';
        axios.get(url).then(function (response) {
            var respuesta = response.data;
            me.arrayDepartamentosUsu = respuesta.departamentos;
        }).catch(function (error) {
            console.log(error);
        })
      },

      selectArchivador(){
        let me = this;
        var url = '/archivadores/selectArchivador/';
        axios.get(url).then(function (response) {
            var respuesta = response.data;
            me.arrayArchivador = respuesta.archivador;
        }).catch(function (error) {
            console.log(error);
        })
      },

      derivar(data){
        this.documento.proveido = '';
        this.arrayDepartamentos = [];
        this.selectDepartamentoUsu();
        this.selectRegion();
        this.tituloModal  = 'DERIVAR DOCUMENTO';
        this.modal = true;
        this.tipoAccion = 1;
        this.documento.id = data;
      },

      archivar(data){
        this.documento.proveido = '';
        this.arrayArchivador = [];
        this.selectArchivador();
        this.tituloModal  = 'ARCHIVAR DOCUMENTO';
        this.modal = true;
        this.tipoAccion = 2;
        this.documento.id = data["id"];

      },

      derivarDocumento(){
        let me = this;
        axios.post('documentos/derivar/'+me.documento.id,{
          'destino' : me.departamento,
          'proveido': me.documento.proveido
        }).then(function(response){
            swal.fire({
              type: 'success',
              title: 'El documento ha sido derivado exitosamente!',
              showConfirmButton: false,
              timer: 1500
            })
            me.closeModal();
            me.listarDocumentos(1, '', '')
        }).catch(error => {
          if(error.response.status == 422){
            me.errores = error.response.data.errors;
          }
        })

      },

      archivarDocumento(){
        let me = this;
        axios.post('documentos/archivar/'+me.documento.id,{
          'archivador' : me.archivador,
          'proveido': me.documento.proveido
        }).then(function(response){
            swal.fire({
              type: 'success',
              title: 'El documento ha sido archivado exitosamente!',
              showConfirmButton: false,
              timer: 1500
            })
            me.closeModal();
            me.listarDocumentos(1, '', '')
        }).catch(error => {
          if(error.response.status == 422){
            me.errores = error.response.data.errors;
          }
        })

      },

      desDerivar(id){
        let me = this;
            swal({
              title: '¿Estas seguro?',
              text: `El destinatario no podra gestionar este documento.`,
              type: 'question',
              showCancelButton: true,
              confirmButtonClass: 'btn btn-success btn-fill',
              cancelButtonClass: 'btn btn-danger btn-fill',
              cancelButtonText: 'Cancelar',
              confirmButtonText: 'Si',
              buttonsStyling: false
            }).then( result => {
              if (result.value) {
                let me = this;
                axios.post('documentos/desderivar/'+id,{
                  }).then(function(response){

                      if(response.data.estado == false){

                        swal.fire({
                          type: 'warning',
                          title: 'Lo sentimos :(',
                          text: 'El documento ya fue recibido o archivado por el destinatario, por lo tanto no puede realizar esta acciòn!',
                          showConfirmButton: true,
                        })

                      }else{

                        swal.fire({
                          type: 'success',
                          title: 'El documento ha sido des-derivado exitosamente!',
                          showConfirmButton: false,
                          timer: 1500
                        })
                      }

                  me.closeModal();
                  me.listarDocumentos(1, '', '')

                  }).catch(error => {
                    if(error.response.status == 422){
                      me.errores = error.response.data.errors;
                    }
                  })
                  }
              })
      },

      desArchivar(id){

        let me = this;
            swal({
              title: '¿Estas seguro?',
              text: `Está desarchivando este documento para gestionarlo`,
              type: 'question',
              showCancelButton: true,
              confirmButtonClass: 'btn btn-success btn-fill',
              cancelButtonClass: 'btn btn-danger btn-fill',
              cancelButtonText: 'No',
              confirmButtonText: 'Si',
              buttonsStyling: false
            }).then( result => {
              if (result.value) {
                let me = this;
                axios.post('documentos/desarchivar/'+id,{
                  }).then(function(response){

                        swal.fire({
                          type: 'success',
                          title: 'El documento ha sido desarchivado exitosamente!',
                          showConfirmButton: false,
                          timer: 1500
                        })

                  me.closeModal();
                  me.listarDocumentos(1, '', '')

                  }).catch(error => {
                    if(error.response.status == 422){
                      me.errores = error.response.data.errors;
                    }
                  })
                  }
              })

      },

      cargarRolesSelect(id){
        var url = 'usuarios/selectRoles/'+id;
        axios.get(url).then((response) => {
          var respuesta = response.data;
          //Obtiene todos los roles
          this.arrayRoles = respuesta.roles;
          //Obtiene todos los roles asociados al usuario seleccionado
          this.roles = respuesta.my_roles;
        }).catch(function (error) {
          console.log(error);
        })

      },

      AgregarRoles() {
       let me = this;
       axios.post('usuarios/agregarRolesUsuario/'+me.user.user_id,{
         'roles' : me.roles,
       }).then(function(response){
          me.closeModal();
          me.listarUsuarios(1, '', '')
          me.notificacion('top', 'right', me.user.nombres, 'actualizado')
       }).catch(error => {
         if(error.response.status == 422){
           me.errores = error.response.data.errors;
         }
       })
      },

      closeModal () {
        this.modal = false;
        this.nombre   = '';
      },

      registrarCargo () {
       let me = this;
       axios.post('usuarios/registrar/',{
         'nombre'       : this.nombre,
       }).then(function(response){
          me.closeModal();
          me.listarUsuarios(1, '', '')
          me.notificacion('top', 'right', response.data.nombre, 'registrada')
       }).catch(error => {
         if(error.response.status == 422){
           me.errores = error.response.data.errors;
         }
       })
      },

      actualizarUsuario(){
          let me = this;
          axios.put('usuarios/actualizar',{
            'id'           : this.user.user_id,
            'nombre'       : this.user.nombres,
          }).then(function (response) {
              me.closeModal();
              me.listarUsuarios(1, '', '');
              me.notificacion('top', 'right', response.data.nombre, 'actualizada')
          }).catch(error => {
            if(error.response.status == 422){
            me.errores = error.response.data.errors;
            }
       })
      },

      descargarDocumento(id){
        let me = this;
        let url = 'documentos/pdf/'+id;
          window.open(url, '_blank')
      },

      verDocuemento(id){
        let me = this;
        me.vista = 2;
        //TRAER TODOS LOS DATOS DEL DOCUMENTO SELECCIONADO, INCLUSO LOS DE LA TABLA PIVOTE PARA VER EL HISOTRIAL DE ESTADOS.
        var url = "documentos/verDocumento/"+id;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.datosDocumento = respuesta;
          console.log(respuesta)
          
          }).catch(function (error) {
          console.log(error);
        })

      },

      notificacion (verticalAlign, horizontalAlign, nombre, tipo) {
        this.$notify(
          {
            message: '<span>El usuario <b>'+nombre+'</b> - ha sido '+tipo+' exitosamente!.</span>',
            icon: 'nc-icon nc-app',
            horizontalAlign: horizontalAlign,
            verticalAlign: verticalAlign,
            type: 'success'
          })
      }, 

    },
    mounted() {
      this.listarDocumentos(1, this.buscar, this.criterio)
    }
  }
</script>
<style>
 .padd{
  padding: 0px 0px;
}
.el-select {
  display: block;
}
.row-color{
    background: #d2f8f7;
  
}



.banda {
    background:#35495E;
    padding: 10px;
    color: white;
}
.card {
    margin-bottom: 5px;
}

.tamano-text{
    font-size: 13px;
}

.card .card-category, .card label {
    font-size: 12px;
}

.card .card-footer {
    padding: 1px 1px 1px 1px;
}

.card .card-body {
    padding: 1px 15px 10px 15px;
}

.el-dialog__body {
    padding: 30px 20px 0;

}

.padding-0{
    padding-right:0;
    padding-left:0;
}

.top-boton{

    top: 30px;

}

</style>