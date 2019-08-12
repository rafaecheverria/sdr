<template>
  <div>
    <notifications></notifications>
          <fade-render-transition :duration="100">
    <card>
      <div slot="header">
        <h4 class="card-title">Lista de Roles</h4>
      </div>
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
            <fg-input placeholder="Buscar" v-model="buscar" @keyup.enter="listarCargos(1, buscar, criterio)"></fg-input>
          </div>
          <div class="col-md-3">
            <l-button type="info" outline wide @click="listarRoles(1, buscar, criterio)">
                <span class="btn-label">
                    <i class="fa fa-search"></i>
                </span>
                Buscar
              </l-button>
          </div>

          <div class="col-md-3">
            <l-button type="success" outline wide  @click="openModal('rol', 'registrar')">
                <span class="btn-label">
                    <i class="fa fa-plus"></i>
                </span>
                Agregar
              </l-button>
          </div>

        </div>
        <div class="row">

        <div class="col-sm-12">

          <div class="table-responsive">

            <el-table stripe style="width: 100%;" :data="tableData">

              <el-table-column prop="name" minWidth= 220 label="Nombre"></el-table-column>

                <el-table-column :min-width="120" fixed="right" label="Actions">

                  <template slot-scope="props">

                    <a v-tooltip.top-center="'Permisos'" class="btn-info btn-simple btn-link"
                      @click="openModal('rol', 'permisos', props.row)">

                      <i class="fa fa-gears"></i>
                      
                    </a>

                    <a v-tooltip.top-center="'Editar'" class="btn-warning btn-simple btn-link"
                      @click="openModal('rol', 'actualizar', props.row)">

                      <i class="fa fa-edit"></i>
                      
                    </a>

                    <a v-tooltip.top-center="'Eliminar'" class="btn-danger btn-simple btn-link">
                        
                        <i class="fa fa-times"></i>
                        
                    </a>

                  </template>

                </el-table-column>

            </el-table>

          </div>

          <!-- Paginación -->

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

    <div class="col-md-12">
        <el-dialog
                :visible.sync="modal">
        <span slot="title" class="dialog-title" v-text="tituloModal"></span>
        <form>
            <div v-if="tipoAccion == 1 || tipoAccion ==2">
                <div class="row">
                    <div class="col-md-12">
                        <fg-input type="text"
                                    name="nombre"
                                    label="Nombre"
                                    :error="errores.nombre"
                                    v-model="nombre">
                        </fg-input>
                    </div>
                </div>

            </div>

            <div v-if="tipoAccion == 3">

                <div class="row">

                    <div class="col-md-12">

                        <el-select class="select-primary"
                            size="large"
                            placeholder="Seleccione un rol para el ususario"
                            v-model="permisos"
                            multiple>

                        <el-option v-for="permiso in arrayPermisos"
                                    class="select-primary"
                                    :value="permiso.id"
                                    :label="permiso.name"
                                    :key="permiso.id">
                        </el-option>
                        
                        </el-select>
                    </div>
                </div>

            </div>

        </form>

        <span slot="footer" class="dialog-footer">

            <button class="btn btn-danger" @click="closeModal()">Cancel</button>&nbsp;

            <button class="btn btn-success" v-if="tipoAccion == 1" @click="registrarRol()">Guardar</button>

            <button class="btn btn-primary" v-if="tipoAccion == 2" @click="actualizarRol()">Actualizar</button>

            <button class="btn btn-primary" v-if="tipoAccion == 3" @click="AgregarPermisos()">Guardar Permisos</button>

        </span>

        </el-dialog>

    </div>

  </div>
</template>
<script>
  import {Dialog, Table, TableColumn, Select, Option, Notification} from 'element-ui'
  import LSwitch from '@/components/Switch.vue'
  import LPagination from '@/components/Pagination.vue'
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
      [Notification.name]: Notification,
      FadeRenderTransition
    },
    data () {
      return {
        modal        : false,
        readonly     : 0,
        nombre       : '',
        telefono     :'',
        tituloModal  : '',
        tableData    : [],
        tipoAccion   : 0,
        rol_id   : 0,
        pagination   :{
          'total'        : 0,
          'current_page' : 0,
          'per_page'     : 0,
          'last_page'    : 0,
          'from'         : 0,
          'to'           : 0,
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
        arrayPermisos: [],
        permisos: []
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
      listarRoles(page, buscar, criterio){
        let me=this;
        var url = 'roles?page='+ page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.tableData = respuesta.roles.data;
          me.pagination = respuesta.pagination;
          }).catch(function (error) {
          console.log(error);
        })
      },
      cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarRoles(page, buscar, criterio);
      },
      openModal (modelo, accion, data = []) {
        switch(modelo){
          case 'rol': 
            switch(accion){
              case 'registrar':
                this.errores= [],
                this.modal = true;
                this.nombre       = '';
                this.tituloModal  = 'Registrar Rol';
                this.tipoAccion   = 1;
                this.readonly = 0;
              break;
              case 'actualizar': 
                this.errores= [],
                this.modal = true;
                this.tituloModal  = 'Actualizar Rol';
                this.tipoAccion   = 2;
                this.nombre       = data['name'];
                this.readonly = 1;
                this.rol_id   = data['id'];
              break;
              case 'permisos': 
                var url = 'permisos/selectPermisos/'+data["id"];
                axios.get(url).then((response) => {
                 var respuesta = response.data;
                 //Obtiene todos los roles
                 this.arrayPermisos = respuesta.permisos;
                 //Obtiene todos los roles asociados al usuario seleccionado
                 this.permisos = respuesta.my_permisos;
                }).catch(function (error) {
                  console.log(error);
                })
                this.errores= [],
                this.modal = true;
                this.tituloModal  = 'Actualizar Rol';
                this.tipoAccion   = 3;
                this.nombre       = data['name'];
                this.readonly = 1;
                this.rol_id   = data['id'];
              break;
            }
        }

      },
      AgregarPermisos() {
       let me = this;
       axios.post('roles/agregarPermisosRol/'+me.rol_id,{
         'permisos' : me.permisos,
       }).then(function(response){
          me.closeModal();
          me.listarRoles(1, '', '')
          me.notificacion('top', 'right', response.data.roles, 'registrada')
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
      registrarRol () {
       let me = this;
       axios.post('roles/registrar/',{
         'nombre'       : this.nombre,
       }).then(function(response){
          me.closeModal();
          me.listarRoles(1, '', '')
          me.notificacion('top', 'right', response.data.nombre, 'registró')
       }).catch(error => {
         if(error.response.status == 422){
           me.errores = error.response.data.errors;
         }
       })
      },
      actualizarRol(){
          let me = this;
          axios.put('roles/actualizar',{
            'id'           : me.rol_id,
            'nombre'       : me.nombre,
          }).then(function (response) {
              me.closeModal();
              me.listarRoles(1, '', '');
              me.notificacion('top', 'right', response.data.nombre, 'actualizó')
          }).catch(error => {
            if(error.response.status == 422){
            me.errores = error.response.data.errors;
            }
       })
      },
      notificacion (verticalAlign, horizontalAlign, nombre, tipo) {
        this.$notify(
          {
            message: '<span>El rol <b>'+nombre+'</b> - se '+tipo+' exitosamente!.</span>',
            icon: 'nc-icon nc-app',
            horizontalAlign: horizontalAlign,
            verticalAlign: verticalAlign,
            type: 'success'
          })
      }, 
    },
    mounted() {
      this.listarRoles(1, this.buscar, this.criterio)
    }
  }
</script>
<style>
  .padd{
    padding: 0px 0px;
  }
</style>