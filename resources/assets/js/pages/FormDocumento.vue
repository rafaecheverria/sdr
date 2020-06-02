<template>
  <div>
    <notifications></notifications>
          <fade-render-transition :duration="100">
    <card>
      <div slot="header">
        <span class="card-title font-weight-normal font-weight-light text-white small text-white">REGISTRAR DOCUMENTO</span>
      </div>
      <br>

      <div class="card-body">

        <div class="row">
           <div class="col-lg-2">
                <label>Interno/Externo</label><br>
                <l-switch v-model="tipo" type="primary" on-text="INT" off-text="EXT"></l-switch>
          </div>

            <div :class="[{'col-lg-2': !tipo}, 'pr-1']" v-show="tipo===false">
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

            <div v-if="tipo == true" class="col-lg-4 pr-1">
             <label>Departamento/JI Infantil</label>
              <el-select class="select-default"
                        size="large"
                        placeholder="Seleccione Departamento"
                        v-model="departamento"
                        v-on:change="changeDepartamento($event)">
                <el-option v-for="departamento in arrayDepartamentosUsu"
                        class="select-primary"
                        :value="departamento.id"
                        :label="departamento.departamento"
                        :key="departamento.id">
                </el-option>
              </el-select>
            </div>

           <!-- SI EL DOCUMENTO ES EXTERNO, SE CARGARÁN LOS DEPARTAMENTOS SEGÚN LA REGIÓN SELECCIONADA8 -->

          <div v-else :class="[{'col-lg-4': !tipo, 'col-lg-6':tipo}, 'pr-1']">
             <label>Departamento/JI Infantil</label>
          <el-select class="select-default"
                     size="large"
                     placeholder="Seleccione Departamento"
                     v-model="departamento"
                     v-on:change="changeDepartamento($event)">
            <el-option v-for="departamento in arrayDepartamentos"
                     class="select-primary"
                     :value="departamento.id"
                     :label="departamento.departamento"
                     :key="departamento.id">
            </el-option>
          </el-select>
          </div>

          <div :class="[{'col-lg-4': !tipo,'col-lg-6':tipo}, 'pr-1']">
             <label>Destinatario</label>
          <el-select class="select-default"
                      size="large"
                      placeholder="Seleccionar"
                      v-model="destinatario"
                      :search="true"
                      v-on:change="changeDerivar($event)">
            <el-option v-for="(destinatario, index) in arrayDestinatarios" :key="index"
                        class="select-primary"
                        :value="destinatario.id"
                        :label="destinatario.nombres+' '+destinatario.apellidos+' ('+destinatario.cargo+')'"
                        >
            </el-option>
          </el-select>
          </div>

        </div>

      <div class="row">
          <div class="col-lg-12 pr-1">
             <label>Remitente</label>
          <el-select class="select-default"
                      size="large"
                      placeholder="Seleccionar"
                      v-model="remitente"
                      :search="true"
                      v-on:change="changeDerivar($event)">
            <el-option v-for="(remitente, index) in arrayRemitentes" :key="index"
                        class="select-primary"
                        :value="remitente.id"
                        :label="remitente.nombres+' '+remitente.apellidos"
                        >
            </el-option>
          </el-select>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 pr-1">
            <fg-input label="Fecha Documento">
              <el-date-picker
                v-model="fecha_documento"
                type="date"
                format="dd-MM-yyyy"
                placeholder="dd-mm-aaaa"
                >
              </el-date-picker>
            </fg-input>
          </div>

          <div class="col-lg-4 pr-1">
             <label>Tipo Docuemento</label>
          <el-select class="select-default"
                      size="large"
                      placeholder="Seleccionar"
                      v-model="tipo_documento"
                      v-on:change="changeTipoDocumento($event)">
            <el-option v-for="tipo_documento in arrayTipoDocumentos"
                        class="select-primary"
                        :value="tipo_documento.id"
                        :label="tipo_documento.tipo_documento"
                        :key="tipo_documento.id">
            </el-option>
          </el-select>
          </div>

          <div class="col-lg-4 pr-1">
            <fg-input label="Numero Docuemento"
                      type="text"
                      v-model="numero_documento"
                      placeholder="Ej:235"
                      :readonly="is_readonly">
            </fg-input>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 pr-1">
             <fg-input label="Asunto">
              <el-input type="text"
                        v-model="asunto"
                        placeholder="Escriba aqui el asunto del documento"
                       >
              </el-input>
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 pr-1">
               
              <vue-editor v-model="detalle"></vue-editor>
             <!-- <fg-input label="Detalle">
              <el-input type="textarea"
                        :rows="5"
                        v-model="detalle"
                        placeholder="Escriba aquí el detalle del documento">
              </el-input>
            </fg-input> -->
          </div>
        </div>

        <div class="row">

          

          <div class="col-lg-4">
            <fg-input label="Folios"
                      v-model="folios"
                      type="number">
            </fg-input>
          </div>

          <div class="col-lg-4">
            <fg-input label="Archivo"
                      v-model="archivo"
                      type="file">
            </fg-input>
          </div>

          <div class="col-lg-4">
             <label>Distribución</label>
              <el-select class="select-default"
                      size="large"
                      placeholder="Seleccionar"
                      v-model="distribucion"
                      multiple>
            <el-option v-for="distribucion in arrayDistribucion"
                        class="select-primary"
                        :value="distribucion.id"
                        :label="distribucion.departamento"
                        :key="distribucion.id">
              </el-option>
          </el-select>
          </div>

        </div>

        <div class="row">


          
        </div>
     </div>
    
<button type="submit" class="btn btn-info btn-fill pull-right" @click="guardar_documento()">Grabar Documento</button>
<div class="clearfix"></div>

</card>
</fade-render-transition>

  </div>
</template>
<script>
  import {DatePicker, Dialog, Table, TableColumn, Select, Option, Notification} from 'element-ui'
  import swal from 'sweetalert2'
  import LSwitch from '@/components/Switch.vue'
  import LPagination from '@/components/Pagination.vue'
  import {FadeRenderTransition} from '@/components/index'
  import moment from 'moment'
  import { VueEditor } from "vue2-editor";
 
  export default{
    components: {
      LSwitch,
      [Dialog.name]: Dialog,
      [DatePicker.name]: DatePicker,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      LPagination,
      [Select.name]: Select,
      [Option.name]: Option,
      [Notification.name]: Notification,
      FadeRenderTransition,
    },
    data () {
      return {
        estado :0,
        modal              :false,
        is_readonly        :true,
        remitente          :'',
        destinatario       :'',
        fecha_documento    :'',
        tipo_documento     :'',
        departamento       :'',
        numero_documento   :'',
        asunto             :'',
        detalle            :'',
        folios             :'',
        archivo            :'',
        derivar            :'',
        copiar             :[],
        distribucion       :'',
        tituloModal        :'',
        tableData          :[],
        tipoAccion         :0,
        region             :'',
        tipo               :true,
        pagination   :{
          'total'        :0,
          'current_page' :0,
          'per_page'     :0,
          'last_page'    :0,
          'from'         :0,
          'to'           :0,
        },
        offset : 4,
        criterio : 'nombre',
        buscar : '',
        selects: {
          simple: '',
          criterios: [
            {value: 'nombre', label: 'Nombre'},
          ],
        },
        errores: [],
        arrayTipoDocumentos: [],
        arrayDepartamentos: [],
        arrayDestinatarios: [],
        arrayRemitentes: [],
        arrayDistribucion: [],
        arrayDepartamentosUsu:[],
        departamentos: [],
        arrayRegiones: []
        
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
          return moment(d).format("dd-mm-yyyy");
      },

      selectTipoDocumento(){
          let me = this;
          var url = 'documentos/selectTipoDocumento/';
          axios.get(url).then(function (response) {
              var respuesta = response.data;
              me.arrayTipoDocumentos = respuesta.tipo_documento;
          }).catch(function (error) {
              console.log(error);
          })
      },
      //CARGA EL NUMERO CORRELATIVO DEL TIPO DE DOCUMENTO SELECCIONADO EN EL SELECT TIPO DOCUMENTO
      changeTipoDocumento(id){
        let me = this;
        var url = 'documentos/correlativos/'+id;
        me.numero_documento = '';
        axios.get(url).then(function (response) {
          console.log(response.data.correlativo);
          if(response.data.correlativo == null){
            me.is_readonly = false;
          }else{
            me.is_readonly = true;
            var numero = Number(response.data.correlativo.numero)
            me.numero_documento = (numero + 1); 
          }
        }).catch(function (error) {
            console.log(error);
        })
      },
      //FUNCION QUE GUARDA EL DOCUMENTO QUE ESTA INGRESANDO EL USUARIO
      guardar_documento(){
       let me = this;
       axios.post('documentos/registrar',{
         'remitente'        : this.remitente,
         'destinatario'     : this.destinatario,
         'fecha_documento'  : this.fecha_documento,
         'tipo_documento'   : this.tipo_documento,
         'departamento'     : this.departamento,
         'departamentos'    : this.departamentos,
         'fecha_documento'  : this.fecha_documento,
         'numero_documento' : this.numero_documento,
         'asunto'           : this.asunto,
         'detalle'          : this.detalle,
         'folios'           : this.folios,
         'archivo'          : this.archivo,
         'derivar'          : this.derivar,
         'copiar'           : this.copiar,
         'tipo'             : this.tipo  
         
       }).then(function(response){

         console.log(response)
         me.clearForm()
          swal({
            text: 'El documento ha sido registrado exitosamente!',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-success btn-fill',
            type: 'success',
            confirmButtonText: 'Aceptar',
          })
          
       }).catch(error => {
         console.log(error)
       })
      },

      //LIMPIA EL FORMULARIO DE CREAR DOCUMENTO
      clearForm(){
        this.remitente = '';
        this.fecha_documento = '';
        this.tipo_documento = '';
        this.departamento = '';
        this.departamentos = '';
        this.fecha_documento = '',
        this.numero_documento = '';
        this.asunto = '';
        this.detalle = '';
        this.folios = '';
        this.archivo = '';
        this.derivar = '';
        this.copiar = [];
        this.arrayDepartamentosCopiar = [];
      },

      changeDerivar(id){
        let me = this;
        me.departamentos = '';
        me.comuna = '';
        var url = 'departamentos/selectDepartamentoCopiar/'+id;
        axios.get(url).then(function (response) {
           var respuesta = response.data;
           me.arrayDepartamentosCopiar = respuesta.copiar;
          }).catch(function (error) {
          console.log(error);
        })
      },

      //CARGA A LOS USUARIOS QUE PERTENECEN AL DEPARTAMENTO DEL USUARIO EN SESIÓN
      selectRemitente(){
          let me = this;
          var url = '/usuarios/selectRemitente/';
          axios.get(url).then(function (response) {
            console.log(response.data)
              var respuesta = response.data;
              me.arrayRemitentes = respuesta.remitente;
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

      //SE EJECUTA CUANDO EL SELECT REGIÓN REALIZA UN CAMBIO  
      //AQUÍ SE CARGAN LOS DEPARTAMENTOS PERTENECIENTES A LA REGIÓN SELECCIONADA ANTERIORMENTE
      changeRegion(id){
            let me = this;
            me.arrayDepartamentos = [];
            me.arrayDestinatarios = [];
            me.departamento = '';
            me.destinatario = '';
            var url = 'departamentos/selectDepartamentoReg/'+id;
            axios.get(url).then(function (response) {
            var respuesta = response.data;
            //Obtiene las comunas de la regiona seleccionada
            me.arrayDepartamentos = respuesta.departamentos;
            }).catch(function (error) {
            console.log(error);
            })
      },

      //SE EJECUTA CUANDO EL SELECT DEPARTAMENTO REALIZA UN CAMBIO  
      //AQUÍ SE CARGAN LOS USUARIOS PERTENECIENTES AL DEPARTAMENTO SELECCIONADO ANTERIORMENTE
      changeDepartamento(id){
          let me = this;
          me.arrayDetinartarios = [];
          me.destinatario = '';
          me.comuna = '';
          var url = 'usuarios/selectUsuarioDepto/'+id;
          axios.get(url).then(function (response) {
          var respuesta = response.data;
          //Obtiene las comunas de la regiona seleccionada
          me.arrayDestinatarios = respuesta.destinatarios;
          }).catch(function (error) {
          console.log(error);
          })
      },

      notificacion (verticalAlign, horizontalAlign, nombre, tipo) {
        this.$notify(
          {
            message: '<span>El Cargo <b>'+nombre+'</b> - ha sido '+tipo+' exitosamente!.</span>',
            icon: 'nc-icon nc-app',
            horizontalAlign: horizontalAlign,
            verticalAlign: verticalAlign,
            type: 'success'
          })
      }, 

    },
    
    mounted() {
      this.selectTipoDocumento();
      this.selectRemitente();
      this.selectRegion();
      this.selectDepartamentoUsu();
    }
  }
</script>
<style>
.form-group {
    margin-bottom: 1rem;
}

.card-header:first-child {
    background:#11BFE3;
    padding: 10px;
    width: 100%;
}
.bootstrap-switch .bootstrap-switch-handle-off {
    background-color: #122038;
}
.bootstrap-switch.bootstrap-switch-off .bootstrap-switch-handle-on {
    background-color: #122038;
}
</style>