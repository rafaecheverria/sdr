<template>
  <div>
    <notifications></notifications>
    <!-- Vista Principal del componente -->
    <div v-if="vista == 1">

      <!-- Formulario de Busqueda de registros -->
      <card>

        <div slot="header"></div>

        <div class="row">

          <div class="col-md-3">

            <el-select class="select-default"

            size="large"

            placeholder="Buscar por:"

            v-model="criterio">

              <el-option v-for="option in selects.criterios"

              class="select-default"

              :value="option.value"

              :label="option.label"

              :key="option.label">

              </el-option>

            </el-select>

          </div>

          <div class="col-md-3 padd">

            <fg-input placeholder="Buscar" v-model="buscar" @keyup.enter="listarCargos(1, buscar, criterio)"></fg-input>

          </div>

          <div class="col-md-3">

            <l-button type="info" outline wide @click="listarCargos(1, buscar, criterio)">

              <span class="btn-label">

                <i class="fa fa-search"></i>

              </span>

            Buscar

            </l-button>

          </div>

          <div class="col-md-3">

            <l-button type="success" outline wide  @click="openModal('vacante', 'registrar')">

              <span class="btn-label">

                <i class="fa fa-plus"></i>

              </span>

              Agregar

            </l-button>

          </div>

        </div>

      </card>

      <!-- Lista Principal de las vacantes -->

      <div class="row">

        <div class="col-md-12" v-for="datos in tableData" :key="datos.id">

          <card>

            <div class="card-header">

              <div class="row">

                <div class="col-md-6">

                  <strong><span class="card-title text-danger" v-text="datos.cargo.toUpperCase()"></span></strong>

                  <div v-if="datos.privacidad == 'no'">

                    <p class="card-category" v-text="datos.empresa"></p>

                  </div>

                </div>

                <div class="col-md-6 text-right">

                  <p class="card-category" v-text="'Publicado '+since(datos.fecha_creado)"></p>  

                </div>

              </div>

            </div>

            <div class="col-md-12 tamano-text" v-text="datos.descripcion"></div>

          <hr size="3" />

            <div class="card-footer"> 
      
              <div class="row">

                <div class="col-md-8 col-sm-12">

                  <i class="fa fa-map-marker text-danger"></i> <span class="card-category" v-text="datos.comuna +', '+ datos.region"></span>


                  <i class="fa fa-clock-o text-primary"></i> <span class="card-category" v-text="datos.tipo_trabajo"></span>


                  <i class="fa fa-circle text-success"></i> <span class="card-category" v-text="datos.estado"></span>

                </div>

                <div class="col-md-4 col-sm-12 text-right">

                  <button class="btn btn-warning" @click="openModal('vacante', 'detalles', datos)">Ver Detalles</button>

                  <button class="btn btn-info" @click="abrirPostulacion(datos)">Postular</button>

                </div>

              </div>    

            </div>

          </card>

        </div>

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

    <!-- Inicia Tab Content del formulario de postulacion -->

     <!-- COMPONENTE DE LA POSTULACION -->

    <div v-if="vista == 2">

      <form-postulacion :vacante="datosVacante"></form-postulacion>

    </div>

    <!-- Ventana Modal -->

    <el-dialog :visible.sync="modal">
      <span slot="title" class="dialog-title" v-text="tituloModal"></span>

      <!-- Agregra Vacante dialog -->

      <form v-if="tipoAccion==1">
        <div>

            <div class="row">

              <div class="col-md-6">

                  <label>Empresa</label>

                <el-select class="select-default"
                            size="large"
                            placeholder="Seleccionar Empresa"
                            v-model="data.formulario.empresa_id"
                            v-on:change="changeEmpresa(data.formulario.empresa_id)">

                    <el-option v-for="empresa in arrayEmpresa"
                                class="select-default"
                                :value="empresa.id"
                                :label="empresa.nombre"
                                :key="empresa.id">

                    </el-option>

                </el-select>

              </div>

              <div class="col-md-6">

                  <label>Sucursal</label>

                 <el-select class="select-default"
                            size="large"
                            placeholder="Seleccione una Sucursal"
                            v-model="data.formulario.sucursal_id">

                        <el-option v-for="sucursal in arraySucursal"
                                    class="select-default"
                                    :value="sucursal.id"
                                    :label="sucursal.direccion +', '+ sucursal.ciudad"
                                    :key="sucursal.id">
                        </el-option>

                    </el-select>

              </div>

            </div>

                <br>

            <div class="row">

              <div class="col-md-6">

                  <label>Selecciones el Cargo</label>

                <el-select class="select-default"
                                size="large"
                                placeholder="Seleccione un Cargo"
                                v-model="data.formulario.cargo_id">

                        <el-option v-for="cargo in arrayCargo"
                                    class="select-default"
                                    :value="cargo.id"
                                    :label="cargo.nombre"
                                    :key="cargo.id">
                        </el-option>

                    </el-select>

              </div>

              <div class="col-md-6">

                    <fg-input type="text"
                            name="duracion_trabajo"
                            v-model="data.formulario.duracion_trabajo"
                            label="Duración del Trabajo">
                    </fg-input>

              </div>

            </div>

         <div class="row">

            <div class="col-md-6">

                  <label>Seleccione Categoría</label>

                <el-select class="select-default"
                                size="large"
                                placeholder="Seleccione un Cargo"
                                v-model="data.formulario.categoria_id">

                        <el-option v-for="categoria in arrayCategoria"
                                    class="select-default"
                                    :value="categoria.id"
                                    :label="categoria.nombre"
                                    :key="categoria.id">
                        </el-option>

                    </el-select>

              </div>

              <div class="col-md-6">

                  <label>Tipo de Trabajo</label>

                    <el-select class="select-default"
                                size="large"
                                placeholder="Tipo de Trabajo"
                                v-model="data.formulario.tipo_trabajo">

                        <el-option v-for="option in selects.tipos"
                                    class="select-default"
                                    :value="option.value"
                                    :label="option.label"
                                    :key="option.label">
                        </el-option>

                    </el-select>

              </div>

          </div>

                <br>

                <fg-input label="Descripción del Cargo">
                  
                    <textarea class="form-control" v-model="data.formulario.descripcion" placeholder="Escriba lo más relevante respecto al cargo seleccionado." rows="3">

                    </textarea>

                </fg-input>

              <div class="row">

                <div class="col-md-12">

                    <label>Preguntas Adicionales</label>

                    <el-select class="select-default"

                      size="large"

                      placeholder=""

                      v-model="tipoPregunta"
                      
                      v-on:change="changePregunta(this)">

                        <el-option v-for="option in selects.preguntas"

                        class="select-default"

                        :value="option.value"

                        :label="option.label"

                        :key="option.label">

                        </el-option>

                    </el-select>

                  </div>

                </div>

                <br>

                <!-- Pregunta abierta -->

                <div v-if="tipoPregunta=='abierta'" class="row">

                  <div class="col-md-10">

                    <fg-input type="text"
                            name="pregunta_abierta"
                            label="Ingrese una pregunta"
                            v-model="data.formulario.newPregunta"
                            placeholder="¿Está usted de acuerdo con la Inclusión Laboral?">
                    </fg-input>
                      
                  </div>

                  <div class="col-md-2 top-boton">

                    <button class="btn btn-success" @click.prevent="addPreguntas">Guardar</button>

                  </div>

                </div>

                <!-- Preguntas predefinidas -->

                <div v-if="tipoPregunta=='predefinida'" class="row">

                  <div class="col-md-10">

                       <label>Selecciona un pregunta predefinida</label>

                        <el-select class="select-default"

                          size="large"

                          placeholder="¿Estarías dispuesto a trabajar por turnos rotativos?"

                          v-model="data.formulario.newPregunta">

                            <el-option v-for="option in selects.predefinidas"

                            class="select-default"

                            :value="option.value"

                            :label="option.label"

                            :key="option.label">

                            </el-option>

                        </el-select>
                      
                  </div>

                  <div class="col-md-2 top-boton">

                    <button class="btn btn-success" @click.prevent="addPreguntas">Guardar</button>

                  </div>

                </div>

                <!-- Preguntas de selección -->

                <div v-if="tipoPregunta=='multiple'" class="row">

                  <div class="col-md-12">

                      <fg-input type="text"
                              name="pregunta_abierta"
                              label="Ingrese una pregunta"
                              v-model="data.formulario.newPregunta"
                              placeholder="¿Está usted de acuerdo con la Inclusión Laboral?">
                      </fg-input>
                      
                  </div>

                   <div class="col-md-5">

                      <fg-input type="text"
                              name="pregunta_abierta"
                              label="Ingrese una pregunta"
                              v-model="data.formulario.opcion1"
                              placeholder="¿Está usted de acuerdo con la Inclusión Laboral?">
                      </fg-input>
                      
                  </div>

                   <div class="col-md-5">

                      <fg-input type="text"
                              name="pregunta_abierta"
                              label="Ingrese una pregunta"
                              v-model="data.formulario.opcion2"
                              placeholder="¿Está usted de acuerdo con la Inclusión Laboral?">
                      </fg-input>
                      
                  </div>

                  <div class="col-md-2 top-boton">

                    <button class="btn btn-success" @click.prevent="addPreguntas">Guardar</button>

                  </div>

                </div>

                <!-- MUESTRA LAS PREGUNTAS AGREGADAS -->

                <div class="row">

                  <div class="col-md-12">

                  <div v-if="data.formulario.preguntas!= []">
                    <br>
                    <l-alert v-for="(pregunta, index) in data.formulario.preguntas" :key="index" type="info">
                        
                            <span v-text="sumarIndex(index)+'.- '+pregunta.pregunta"></span>
                            <button class="delete-pregunta" @click.prevent="delPreguntas(index)">X</button>

                  </l-alert>
                  
                  </div>

                  </div>

                </div>

            <fg-input>
              
              <br> 

              <checkbox v-model="data.formulario.privacidad"
                        name="privacidad">Publicación Privada
              </checkbox>

            </fg-input>

        </div>

      </form>

      <!-- Detalle Dialog -->

      <div v-if="tipoAccion==3">

        <div class="row">
            <label class="col-md-3"><strong>Cargo</strong></label>
            <span class="col-md-9" v-text="data.detalle.cargo"></span>
        </div>
        <hr class="line">
        <div class="row">
            <label class="col-md-3"><strong>Área</strong></label>
            <span class="col-md-9" v-text="data.detalle.categoria"></span>
        </div>
        <hr class="line">
        <div class="row">
            <label class="col-md-3"><strong>Publicado</strong></label>
            <span class="col-md-9" v-text="since(data.detalle.fecha_creado)"></span>
        </div>
        <hr class="line">

        <div class="row">
          <label class="col-md-3"><strong>Empresa</strong></label>
          <div v-if="data.detalle.privacidad== 'si'">
            <span class="col-md-9 text-danger tamano-text" v-text="'Esta información es confidencial'"></span>
          </div>
          <div v-else>
            <span class="col-md-9" v-text="data.detalle.empresa"></span>
          </div>
        </div>

        <hr class="line">

        <div class="row">
          <label class="col-md-3"><strong>Sucursal</strong></label>
          <div v-if="data.detalle.privacidad== 'si'">
            <span class="col-md-9 tamano-text text-danger" v-text="'Esta información es confidencial'"></span>
          </div>

          <div v-else>
            <span class="col-md-9" v-text="data.detalle.sucursal+', '+data.detalle.comuna"></span>
          </div>

        </div>
        <hr class="line">
        <div class="row">
            <label class="col-md-3"><strong>Tipo</strong></label>
            <span class="col-md-9" v-text="data.detalle.tipo_trabajo"></span>
        </div>
        <hr class="line">
        <div class="row">
            <label class="col-md-3"><strong>Estado</strong></label>
            <span class="col-md-9 text-success tamano-text" v-text="data.detalle.estado.toUpperCase()"></span>
        </div>
        <hr class="line">
        <div class="row">
            <label class="col-md-3"><strong>Duración</strong></label>
            <span class="col-md-9" v-text="data.detalle.duracion_trabajo"></span>
        </div>
        <hr class="line">
        <div class="row">
            <label class="col-md-3"><strong>Descripción</strong></label>
            <span class="col-md-9" v-text="data.detalle.descripcion"></span>
        </div>
      </div>

      <!-- Footer Dialog -->
    
      <template slot="footer">
        <hr>
          <div class="stats">
            <span slot="footer" class="dialog-footer">

              <button class="btn btn-danger" @click="closeModal()">Cancelar</button>&nbsp;
              <button class="btn btn-success" v-if="tipoAccion == 1" @click="registrarVacante()">Guardar</button>
              <button class="btn btn-primary" v-if="tipoAccion == 2" @click="actualizarVacante()">Actualizar</button>
            </span>
          </div>
      </template>

    </el-dialog>

  </div>
</template>
<script>
  // import bus from '@/event-bus'
  import {DatePicker, Dialog, Table, TableColumn, Select, Option} from 'element-ui'
  import LAlert from '@/components/Alert'
  import moment from 'moment'
  import FormPostulacion from './Postulacion.vue'

  import {
    Progress as LProgress,
    Switch as LSwitch,
    Radio,
    FormGroupInput as FgInput,
    Pagination as LPagination,
    Checkbox 
  } from '@/components/index'

  moment.locale('es')

  export default{
    components: {
      LSwitch,
      [DatePicker.name]: DatePicker,
      [Dialog.name]: Dialog,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      LPagination,
      [Select.name]: Select,
      [Option.name]: Option,
      Checkbox,
      FormPostulacion,
      LAlert,
      Radio

    },
    data () {
      return {
        data:{
          formulario:{
            empresa_id   : '',
            cargo_id     : '',
            codigo       : '',
            sucursal_id  : '',
            fecha        : [],
            descripcion  : '',
            tipo_trabajo : '',
            categoria_id : '',
            duracion_trabajo : '',
            privacidad   : false,
            sucursal     : '',
            cargo        : '',
            newPregunta  : '',
            preguntas    : [],
            opcion1      : '',
            opcion2      : '',
          },
          detalle:{
            vacante_id       : '',
            empresa          : '',
            cargo            : '',
            codigo           : '',
            sucursal         : '',
            descripcion      : '',
            tipo_trabajo     : '',
            categoria        : '',
            duracion_trabajo : '',
            privacidad       : '',
            fecha_creado     : '',
            comuna           : ''
          },
        },
        modal        : false,
        readonly     : 0,
        vacante_id   : 0,
        tituloModal  : '',
        tableData    : [],
        tipoAccion   : 0,
        vista        : 1,
        pagination   : {
          'total'        : 0,
          'current_page' : 0,
          'per_page'     : 0,
          'last_page'    : 0,
          'from'         : 0,
          'to'           : 0,
        },
        offset      : 4,
        criterio    : '',
        buscar      : '',
        selects     : {
          simple    : '',
          tipos : [
            {value: 'Full-time', label: 'Full-time'},
            {value: 'Part-time', label: 'Part-time'},
            {value: 'Part-time & Full-time', label: 'Part-time & Full-time'},
          ],
          preguntas : [
            {value: '', label: 'Seleccione'},
            {value: 'predefinida', label: 'Predefinidas'},
            {value: 'abierta', label: 'Abierta'},
            {value: 'multiple', label: 'Multiple de selección'},
          ],
          predefinidas : [
            {value: '', label: 'Seleccione una pregunta'},
            {id: 1, value: '¿Cuál es tu expectativa salarial neta para un cambio?', label: '¿Cuál es tu expectativa salarial neta para un cambio?'},
            {id: 2, value: '¿Cuál es tu expectativa salarial bruta para un cambio?', label: '¿Cuál es tu expectativa salarial bruta para un cambio?'},
            {id: 3, value: '¿Cuál es tu disponibilidad para comenzar a trabajar con nosotros?', label: '¿Cuál es tu disponibilidad para comenzar a trabajar con nosotros?'},
            {id: 4, value: '¿Cuentas con movilidad propia?', label: '¿Cuentas con movilidad propia?'},
            {id: 5, value: '¿Posees licencia para conducir? Aclara por favor para qué tipo de vehículos?', label: '¿Posees licencia para conducir? Aclara por favor para qué tipo de vehículos?'},
            {id: 6, value: '¿Estarías dispuesto a trabajar en turnos rotativos? ', label: '¿Estarías dispuesto a trabajar en turnos rotativos? '}, 
          ],
        },
        errores        : [],
        arrayEmpresa   : [],
        arrayCargo     : [],
        arraySucursal  : [],
        arrayCategoria : [],
        arrayRegiones  : [],
        arrayComunas   : [],
        tipoPregunta   : '',
        datosVacante   : []
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
      sumarIndex: function (index) {
        return index+1
      },
      since: function(d){
          return moment(d).fromNow();
      },
      format_fecha: function(d){
          return moment(d).format("dddd, D MMMM YYYY, h:mm:ss a");
      },
      format_hora: function(d){
          return moment(d).format("H:m");
      },
      addPreguntas: function(){
        var pregunta = this.data.formulario.newPregunta;
        var preguntas = this.data.formulario.preguntas
        preguntas.push({ pregunta : pregunta, tipo: this.tipoPregunta })
        preguntas.forEach((ob,item)=>this.$set(ob, 'id', Number(item+(1))));
        this.tipoPregunta = ''
        pregunta = ''
        // var tipo = this.tipoPregunta;
        // var opcion1 = this.data.formulario.opcion1;
        // var opcion2 = this.data.formulario.opcion2;
        // if(pregunta){
        //   if(tipo == 'multiple'){
        //     this.data.formulario.preguntas.push({ pregunta : pregunta, tipo: tipo, opcion1: opcion1, opcion2: opcion2 })
        //   }else{
        //     this.data.formulario.preguntas.push({ pregunta : pregunta, tipo: this.tipoPregunta })
        //     // for(i in this.data.formulario.preguntas){
        //     //     this.$set(this.data.formulario.preguntas[i], 'title', "titulo"); 
        //     //     this.$set(this.data.formulario.preguntas[i], 'descripcion', "mi descripcion");
        //     // }
        //     // console.log(this.data.formulario.preguntas)
        //   }
        //   this.tipoPregunta = ''
        //   this.data.formulario.newPregunta = ''
        // }
      },
      delPreguntas: function(index){
        console.log(index)
       var pregunta = this.data.formulario.preguntas;
        pregunta.splice(index ,1);
        
      },
      changePregunta(){
        switch(this.tipoPregunta){

          case '':
              // this.tipoPregunta = 0
          break;
          case 'predefinidas':
              this.data.formulario.newPregunta = ''
          break;
          case 'abierta':
             this.data.formulario.newPregunta = ''
          break;
          case 'multiple':
              // this.tipoPregunta = 3
          break;
        }
      },
      listarVacantes(page, buscar, criterio){
        let me=this;
        var url = '/api/vacantes?page='+ page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.tableData = respuesta.vacantes.data;
          me.pagination = respuesta.pagination;
          }).catch(function (error) {
          console.log(error);
        })
      },
      abrirPostulacion(datos){
        let me = this;
        me.vista = 2;
        this.datosVacante = datos;
        // console.log(datos)
        // me.data.formulario.sucursal     = datos['sucursal'];
        // me.data.formulario.cargo        = datos['cargo'];
        // me.data.formulario.fecha_creado = datos['fecha_creado'];
        // me.formulario.preguntas_adicionales = JSON.parse(datos['preguntas'])
        // me.data.formulario.empresa      = datos['privacidad']=="no"?datos['empresa']+' - ': "";
        // console.log(me.formulario.preguntas_adicionales)
      },
      selectEmpresa(){
        let me=this;
        var url = 'empresas/selectEmpresa';
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.arrayEmpresa = respuesta.empresas;
          }).catch(function (error) {
          console.log(error);
        })
      },
      selectCategoria(){
        let me=this;
        var url = '/api/categorias/selectCategoria';
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.arrayCategoria = respuesta.categorias;
          }).catch(function (error) {
          console.log(error);
        })
      },
      changeEmpresa(empresa_id){
        let me=this;
        me.arraySucursal = [];
        me.arrayCargo = [];
        me.data.formulario.sucursal_id = '';
        me.data.formulario.cargo_id = '';
        var url = '/api/sucursales/selectSucursal/'+empresa_id;
        axios.get(url).then(function (response) {
          console.log(response.data)
          var respuesta = response.data;
         //Obtiene las sucursales de la empresa seleccionada
          me.arraySucursal = respuesta.sucursales;
          //Obtiene los carogs que estan asociados a la empresa seleccionada
          me.arrayCargo = respuesta.cargos;
          }).catch(function (error) {
          console.log(error);
        })
      },
      selectCargo(){
        let me=this;
        console.log(me.data.formulario.empresa_id)
        var url = '/api/cargos/selectCargo/'+0;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.arrayCargo = respuesta.cargos;
          }).catch(function (error) {
          console.log(error);
        })
      },
      cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarVacantes(page, buscar, criterio);
      },
      openModal (modelo, accion, data = []) {
        switch(modelo){
          case 'vacante': 
            switch(accion){
              case 'registrar':
                this.errores= [],
                this.modal = true;
                this.nombre       = '';
                this.tituloModal  = 'GENERAR VACANTE';
                this.tipoAccion   = 1;
                this.readonly = 0;
              break;
              case 'actualizar': 
                this.errores= [],
                this.modal = true;
                this.tituloModal  = 'ACTUALIZAR VACANTE';
                this.tipoAccion   = 2;
                this.nombre       = data['nombre'];
                this.readonly = 1;
                this.cargo_id   = data['id'];
              break;
              case 'detalles': 
                this.errores= [],
                this.modal = true;
                this.tituloModal  = 'DETALLES DE LA VACANTE';
                this.tipoAccion   = 3;
                this.readonly = 1;
                this.data.detalle.vacante_id       = data['id'];
                this.data.detalle.cargo            = data['cargo'];;
                this.data.detalle.empresa          = data['empresa'];
                this.data.detalle.descripcion      = data['descripcion'];
                this.data.detalle.sucursal         = data['sucursal'];
                this.data.detalle.privacidad       = data['privacidad'];
                this.data.detalle.categoria        = data['categoria'];
                this.data.detalle.tipo_trabajo     = data['tipo_trabajo'];
                this.data.detalle.duracion_trabajo = data['duracion_trabajo'];
                this.data.detalle.estado           = data['estado'];
                this.data.detalle.fecha_creado     = data['fecha_creado'];
                this.data.detalle.comuna           = data['comuna'];                
              break;
            }
        }
        this.selectEmpresa();
        this.selectCargo();
        this.selectCategoria();
      },
      closeModal () {
        this.modal = false;
        this.nombre   = '';
      },
      registrarVacante () {
        let me = this;
         axios.post('api/vacantes/registrar',{
           'empresa_id'  : me.data.formulario.empresa_id,
           'sucursal_id' : me.data.formulario.sucursal_id,
           'cargo_id'    : me.data.formulario.cargo_id,
           'descripcion' : me.data.formulario.descripcion,
           'categoria_id': me.data.formulario.categoria_id,
           'tipo_trabajo': me.data.formulario.tipo_trabajo,
           'privacidad'  : me.data.formulario.privacidad,
           'duracion_trabajo'  : me.data.formulario.duracion_trabajo,
           'preguntas_adicionales': JSON.stringify(me.data.formulario.preguntas)
         }).then(function(response){
            me.closeModal();
            me.listarVacantes(1, '', '')
            me.notificacion('top', 'right', 'La Vacante fue agregada exitosamente!')
         }).catch(error => {
           if(error.response.status == 422){
             me.errores = error.response.data.errors;
           }
         })
      },
      actualizarCargo(){
          let me = this;
          axios.put('api/cargos/actualizar',{
            'id'           : this.cargo_id,
            'nombre'       : this.nombre,
          }).then(function (response) {
              me.closeModal();
              me.listarCargos(1, '', '');
              me.notificacion('top', 'right', response.data.nombre, 'actualizada')
          }).catch(error => {
            if(error.response.status == 422){
            console.log(error)
            me.errores = error.response.data.errors;
            }
       })
      },
      notificacion (verticalAlign, horizontalAlign, parametro, tipo) {
        this.$notify(
          {
            message: '<span>'+parametro+'</b></span>',
            icon: 'nc-icon nc-app',
            horizontalAlign: horizontalAlign,
            verticalAlign: verticalAlign,
            type: 'success'
          })
      }, 
      validateStep (ref) {
        return this.$refs[ref].validate()
      },
      onStepValidated (validated, model) {
        this.wizardModel = {...this.wizardModel, ...model}
      },
      validate () {
        return this.$validator.validateAll().then(res => {
          this.$emit('on-validated', res, this.model)
          return res  
          console.log(res)
        })
      },
      selectRegion(){
        let me = this;
          var url = '/api/regiones/selectRegion/';
          axios.get(url).then(function (response) {
            var respuesta = response.data;
            //Obtiene las regiones
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
    },
    mounted() {
      this.listarVacantes(1, this.buscar, this.criterio)
      this.selectRegion()

      this.$validator.localize('en', {
      messages: {
        required: (field) => '* ' + field + ' es requerido',
        min: (field) => '* ' + field + ' debe tener un minimo de caracteres',
        numeric: (field) => '* ' + field + ' debe tener sólo números',
        email: (field) => '* ' + field + ' tiene un formato incorrecto',
      },
      attributes: {
        email: 'Email',
        telefono: 'Telefono',
        nombres: 'Nombres',
        apellidos: 'Apellidos',
        region: 'Region',
        comuna: 'Comuna',
        direccion: 'Dirección',
        rut: 'Rut',
        fecha_nacimiento: 'Fecha de Nacimiento',
        genero: 'Género',
        discapacidad: 'Discapacidad'
      } 
    })
    }
  }
</script>
<style lang="scss">
.padd{
  padding: 0px 0px;
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

.vue-form-wizard .wizard-icon-circle.tab_shape {
    background-color: #9A9A9A !important;
    color: white;
  }
  .vue-form-wizard .wizard-tab-content {
    display: flex; // to avoid horizontal scroll when animating
    .wizard-tab-container {
      display: block;
      animation: fadeIn 0.5s;
    }
  }

  .vue-form-wizard .category {
    text-align: left;
}
.vue-form-wizard .wizard-title {
    text-align: left;
    font-size: 21px;
    text-transform: uppercase;
        font-weight: 400;
    color: grey;
}

.vue-form-wizard .wizard-header {
    padding: 10px 8px 0px 10px;
}

.top-boton{

    top: 30px;

}

.delete-pregunta {
    position: absolute;
    right: 10px;
    top: 50%;
    margin-top: -13px;
    z-index: 3;
    background-color: #FFFFFF;
    display: block;
    border-radius: 50%;
    opacity: 0.4;
    line-height: 9px;
    width: 25px;
    height: 25px;
    outline: 0 !important;
    text-align: center;
    padding: 3px;
    font-weight: 300;
}
</style>
