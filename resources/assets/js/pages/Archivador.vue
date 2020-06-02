<template>
  <div>
    <notifications></notifications>
    <fade-render-transition :duration="100">
    <card class="col-md-12">
      <div slot="header">
        <span class="card-title font-weight-normal font-weight-light text-white small text-white">LISTA DE ARCHIVADORES</span>
      </div>
      <br>
      <!-- FILTROS DE BÚSQUEDA -->
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
            <fg-input placeholder="Buscar" v-model="buscar" @keyup.enter="listarArchivadores(1, buscar, criterio)"></fg-input>
          </div>
          <div class="col-md-3">
            <l-button type="info" outline wide @click="listarArchivadores(1, buscar, criterio)">
                <span class="btn-label">
                    <i class="fa fa-search"></i>
                </span>
                Buscar
              </l-button>
          </div>

          <div class="col-md-3">
            <l-button type="success" outline wide  @click="openModal('archivador', 'registrar')">
                <span class="btn-label">
                    <i class="fa fa-plus"></i>
                </span>
                Agregar
              </l-button>
          </div>
      </div>

        <!-- LISTA PRINCIPAL DE LAS EMPRESAS -->
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <el-table stripe style="width: 100%;" :data="tableData">
                <el-table-column prop="archivador" minWidth= 400 label="Archivador"></el-table-column>
                  <el-table-column :min-width="120" fixed="right" label="Actions">
                    <template slot-scope="props">

                      <a v-tooltip.top-center="'Editar'" class="btn-warning btn-simple btn-link"
                        @click="openModal('archivador', 'actualizar', props.row)"><i
                        class="fa fa-edit"></i>
                      </a>

                      <a v-tooltip.top-center="'Eliminar'" class="btn-danger btn-simple btn-link">
                        <i class="fa fa-times"></i>
                      </a>
                   
                   </template>
                  </el-table-column>
              </el-table>
            </div>

            <!-- PAGINACION -->

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
    
    </fade-render-transition>

    <!-- DIALOG -->

    <div class="col-md-12">
      <el-dialog :visible.sync="modal">
        <span slot="title" class="dialog-title" v-text="tituloModal"></span>
        <form>
          <div v-if="tipoAccion==1 || tipoAccion==2">
          <br>
          <div class="row">
             <div class="col-md-12">

              

                <fg-input type="text"
                    name="archivador"
                    label="Nombre del Archivador"
                    :error="errores.archivador"
                    v-model="archivador">
                </fg-input>
   
            </div>
            <div class="col-md-12">
            <label>Seleccione Periodo</label>
              <el-select class="select-default"
                         size="large"
                         name="periodo"
                         placeholder="Ej: 2019"
                         v-model="periodo">
                  <el-option :value="''"></el-option>
                  <el-option v-for="option in selects.anos"
                      class="select-primary"
                      :value="option.value"
                      :label="option.label"
                      :key="option.value">
                  </el-option>
              </el-select>
            </div> 

             
          </div>
      
        <br>
          </div>
        </form>
        <!-- PANEL DE BOTONES -->
        <span slot="footer" class="dialog-footer">
          <button class="btn btn-danger" @click="closeModal()">Cancel</button>&nbsp;
          <button class="btn btn-success" v-if="tipoAccion == 1" @click="registrarArchivador()">Guardar</button>
          <button class="btn btn-primary" v-if="tipoAccion == 2" @click="actualizarArchivador()">Actualizar</button>
        </span>
      </el-dialog>
    </div>

  </div>
</template>
<script>
  import {Dialog, Table, TableColumn, Tag, Select, Option} from 'element-ui'
  import LSwitch from '../components/Switch.vue'
  import LPagination from '../components/Pagination.vue'
  import {FadeRenderTransition } from '@/components/index'

  export default{
    components: {
      LSwitch,
      [Dialog.name]: Dialog,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      LPagination,
      [Select.name]: Select,
      [Option.name]: Option,
      FadeRenderTransition
    },
    data () {
      return {
        modal        : false,
        readonly     : 0,
        archivador   : '',
        tituloModal  : '',
        periodo      : '',
        tableData    : [],
        tipoAccion   : 0,
        archivador_id   : 0,
        pagination   : {
          'total'        : 0,
          'current_page' : 0,
          'per_page'     : 0,
          'last_page'    : 0,
          'from'         : 0,
          'to'           : 0,
        },
        offset   : 4,
        criterio : '',
        buscar   : '',
        selects: {
          simple : '',
          criterios: [
            {value: 'archivador', label: 'Archivador'},
          ],
          anos: [
            {value: '2019', label: '2019'},
            {value: '2020', label: '2020'},
            {value: '2021', label: '2021'},
            {value: '2022', label: '2022'},
            {value: '2023', label: '2023'},
            {value: '2024', label: '2024'},
            {value: '2025', label: '2025'},
            {value: '2026', label: '2026'},
            {value: '2027', label: '2027'},
            {value: '2029', label: '2029'},
            {value: '2030', label: '2030'},
            {value: '2031', label: '2031'},
            {value: '2032', label: '2032'},
          ],
        },
        errores      : [],
        arrayArchivadores : [],
        modelValidations: {
          archivador: {
            required: true,
          },
        }
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
          return moment(d).format("dddd, D MMMM YYYY, h:mm:ss a");
      },
      listarArchivadores(page, buscar, criterio){
        let me=this;

        var url = 'archivadores?page='+ page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
          console.log(response)
          var respuesta = response.data;
          me.tableData = respuesta.archivadores.data;
          me.pagination = respuesta.pagination;
          }).catch(function (error) {
          console.log(error);
        })
      },
      cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarArchivadores(page, buscar, criterio);
      },
      openModal (modelo, accion, data = []) {
        switch(modelo){
          case 'archivador': 
            switch(accion){
              case 'registrar':
                this.clearError()
                this.errores      = [],
                this.modal        = true;
                this.archivador       = '';
                this.tituloModal  = 'INGRESAR ARCHIVADOR';
                this.tipoAccion   = 1;
                this.readonly     = 0;
              break;
              case 'actualizar': 
                this.clearError()
                this.errores      = [],
                this.modal        = true;
                this.tituloModal  = 'ACTUALIZAR ARCHIVADOR ' +data['archivador'].toUpperCase();
                this.tipoAccion   = 2;
                this.archivador = data['archivador'];
                this.periodo    = data['periodo'];;
                this.archivador_id   = data['id'];
            }
        }
      },
      closeModal () {
        this.modal = false;
        this.nombre   = '';
        this.email    = '';
        this.direccion= '';
        this.telefono = '';
        this.rut      = '';
        this.razon_social = '';
      },
      registrarArchivador () {
       this.validate()
       let me = this;
       axios.post('archivadores/registrar',{
         'archivador' : this.archivador,
         'periodo'    : this.periodo,
       }).then(function(response){
          me.closeModal();
          me.listarArchivadores(1, '', '')
          me.notificacion('top', 'right', response.data.archivador, 'registrado')
          me.clearError()
       }).catch(error => {
         console.log(error)
       })
      },
      actualizarArchivador(){
          let me = this;
          axios.put('archivadores/actualizar',{
            'id'           : this.archivador_id,
            'archivador' : this.archivador,
            'periodo'    : this.periodo,   
          }).then(function (response) {
              me.closeModal();
              me.listarArchivadores(1, '', '');
              me.notificacion('top', 'right', response.data.archivador, 'actualizada')
              me.clearError()
          }).catch(error => {
            console.log(error)            
          })
      },
      notificacion (verticalAlign, horizontalAlign, departamento, tipo) {
        this.$notify(
          {
            message: '<span>El archivador <b>'+archivador+'</b> - ha sido '+tipo+' exitosamente!.</span>',
            icon: 'nc-icon nc-app',
            horizontalAlign: horizontalAlign,
            verticalAlign: verticalAlign,
            type: 'success'
          })
      },
      getError (fieldName) {
        return this.errors.first(fieldName)
      },
      clearError(){
        this.$validator.reset();
      },
      validate() {
         return this.$validator.validateAll().then(res => {
            this.$emit('on-validated', res, this.model)
            return res  
            })

    	  // this.$validator.validateAll().then(success => {
        //  if (! success) {
        //  	return;
        //  }
        //  post().then(() => {
        //    this.email = '';
        //    alert('success');
        //  }).then(() => {
        //  	 this.errors.clear();
        //  });
        // });
      }
    },
    mounted() {
      this.listarArchivadores(1, this.buscar, this.criterio);
      //traductor de mensajes de errores del componente
      this.$validator.localize('es', {
        messages: {
          required: (field) => '* ' + field + ' es requerido',
          min: (field) => '* ' + field + ' debe tener un minimo de 5 caracteres',
          numeric: (field) => '* ' + field + ' debe tener sólo números'
        },
        attributes: {
          archivador : 'Archivador',
        } 
      })
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

</style>
