<template>
  <div>
    <notifications></notifications>
          <fade-render-transition :duration="100">
    <card>
      <!-- Busqueda -->
      <div slot="header">
        <h4 class="card-title">Lista de Usuarios</h4>
            <fg-input label="Nombres"
                    name="nombres"
                    autofocus
                    :value="auth.nombres"
                    placeholder="Ej: Daniel Orlando">
            </fg-input>
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
            <fg-input placeholder="Buscar" v-model="buscar" @keyup.enter="listarUsuarios(1, buscar, criterio)"></fg-input>
          </div>
          <div class="col-md-3">
            <l-button type="info" outline wide @click="listarUsuarios(1, buscar, criterio)">
                <span class="btn-label">
                    <i class="fa fa-search"></i>
                </span>
                Buscar
              </l-button>
          </div>

          <div class="col-md-3">
            <l-button type="success" outline wide  @click="openModal('usuario', 'registrar')">
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
              <el-table-column prop="nombres" minWidth= 220 label="Nombres"></el-table-column>
               <el-table-column prop="apellidos" minWidth= 220 label="Apellidos"></el-table-column>
               <el-table-column prop="email" minWidth= 220 label="Email"></el-table-column>
                <el-table-column :min-width="120" fixed="right" label="Actions">
                  <template slot-scope="props">
                    <a v-tooltip.top-center="'Vincular a una Empresa'" class="btn-success btn-simple btn-link"
                      @click="openModal('usuario', 'empresas', props.row)">
                      <i class="fa fa-building"></i>
                    </a>

                    <a v-tooltip.top-center="'Editar'" class="btn-warning btn-simple btn-link"
                      @click="openModal('usuario', 'actualizar', props.row)"><i
                      class="fa fa-edit"></i></a>
                    <a v-tooltip.top-center="'Eliminar'" class="btn-danger btn-simple btn-link"><i class="fa fa-times"></i></a>
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
      </fade-render-transition>

      <!-- Dialog -->

    <div class="col-md-12">
      <el-dialog
              :visible.sync="modal">
        <span slot="title" class="dialog-title" v-text="tituloModal"></span>
        <form>

          <div v-if="tipoAccion == 1 || tipoAccion ==2">
            <div class="row">
              <div class="col-md-6">
              <fg-input type="text"
                        name="rut"
                        label="Rut"
                        :readonly="readonly == 1 ? true : false"
                        v-model="user.rut">
              </fg-input>
              
              </div>
              <div class="col-md-6">
              <fg-input type="text"
                        name="nombres"
                        label="Nombres"
                        v-model="user.nombres">
              </fg-input>
              
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
              <fg-input type="text"
                        name="apellidos"
                        label="Apellidos"
                        v-model="user.apellidos">
              </fg-input>
              
              </div>
              <div class="col-md-6">
              <fg-input type="text"
                        name="email"
                        label="Email"
                        v-model="user.email">
              </fg-input>
              
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                  <label>Fecha Nacimiento</label>
                <fg-input>
              <el-date-picker :format="format_fecha(user.nacimiento)" v-model="user.nacimiento" type="date" placeholder="Fecha de Nacimiento">
              </el-date-picker>
            </fg-input>
              
              </div>
              <div class="col-md-6">
              <fg-input type="text"
                        name="telefono"
                        label="Telefono"
                        v-model="user.telefono">
              </fg-input>
              
              </div>
            </div>
             <!-- <div class="row">
              <div class="col-md-12">
                
                <el-select class="select-primary"
                      size="large"
                      placeholder="Seleccione un rol para el ususario"
                      v-model="roles"
                      multiple>
                      <el-option v-for="role in arrayRoles"
                                  class="select-primary"
                                  :value="role.id"
                                  :label="role.name"
                                  :key="role.id">
                      </el-option>
                </el-select>
              
              </div>
            </div> -->
          </div>

          <div v-if="tipoAccion == 3">
            <div class="row">
              <div class="col-md-12">
                
                <el-select class="select-primary"
                      size="large"
                      placeholder="Seleccione empresas para el ususario"
                      v-model="empresas"
                      multiple>
                      <el-option v-for="empresa in arrayEmpresas"
                                  class="select-primary"
                                  :value="empresa.id"
                                  :label="empresa.nombre"
                                  :key="empresa.id">
                      </el-option>
                </el-select>
              
              </div>
            </div>
          </div>

        </form>

        <span slot="footer" class="dialog-footer">
          <button class="btn btn-danger" @click="closeModal()">Cancel</button>&nbsp;
          <button class="btn btn-success" v-if="tipoAccion == 1" @click="registrarUsuario()">Guardar</button>
          <button class="btn btn-success" v-if="tipoAccion == 2" @click="actualizarUsuario()">Guardar</button>
          <button class="btn btn-info" v-if="tipoAccion == 3" @click="AgregarEmpresas()">Vincular Empresas</button>
        </span>
      </el-dialog>
     </div>

  </div>
</template>
<script>
  import {DatePicker, Dialog, Table, TableColumn, Select, Option, Notification} from 'element-ui'
  import LSwitch from '@/components/Switch.vue'
  import LPagination from '@/components/Pagination.vue'
  import {FadeRenderTransition } from '@/components/index'
  import moment from 'moment'
  export default{
       props: [
        'auth'
    ],
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
      FadeRenderTransition
    },
    data () {
      return {
        modal        : false,
        user  :{
          user_id: 0,
          nombres: '',
          apellidos:'',
          email:'',
          rut: '',
          nacimiento:'',
          telefono: ''
        },
        readonly     : 0,
        telefono     :'',
        tituloModal  : '',
        tableData    : [],
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
        arrayEmpresas: [],
        empresas: []
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
          return moment(d).format("DD/MM/YY");
      },
      listarUsuarios(page, buscar, criterio){
        let me=this;
        var url = 'usuarios?page='+ page + '&buscar='+ buscar + '&criterio='+ criterio + '&tipo='+ 'Moderador';
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.tableData = respuesta.usuarios.data;
          me.pagination = respuesta.pagination;
          }).catch(function (error) {
          console.log(error);
        })
      },
      cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarUsuarios(page, buscar, criterio);
      },
      openModal (modelo, accion, data = []) {
        switch(modelo){
          case 'usuario': 
            switch(accion){
              case 'registrar':
                this.arrayempresas  = []
                this.errores        = [],
                this.modal          = true;
                this.nombre         = '';
                this.tituloModal    = 'Registrar Usuario';
                this.tipoAccion     = 1;
                this.readonly       = 0;
              break;
              case 'actualizar': 
                this.arrayempresas  = []
                this.errores        = [];
                this.modal          = true;
                this.tituloModal    = 'Actualizar al Moderador - ' +data["nombres"];
                this.tipoAccion     = 2;
                this.user.nombres   = data['nombres'];
                this.user.rut       = data['rut'];
                this.user.apellidos = data['apellidos'];
                this.user.email     = data['email'];
                this.user.telefono  = data['telefono'];
                this.user.acimiento = data['fecha_nacimiento'];
                this.readonly       = 1;
                this.cargo_id       = data['id'];
              break;
              case 'empresas': 
                this.arrayEmpresas  = []
                this.cargarEmpresasSelect(data['id'])
                this.errores        = [],
                this.modal          = true;
                this.tituloModal    = 'empresas de Usuario';
                this.tipoAccion     = 3;
                this.user.nombres   = data['nombres'];
                this.readonly       = 1;
                this.user.user_id   = data['id'];
              break;
              
            }
        }

      },
      cargarEmpresasSelect(id){
        var url = 'usuarios/selectEmpresas/'+id;
        axios.get(url).then((response) => {
            console.log(response.data)
          var respuesta = response.data;
          //Obtiene todos los empresas
          this.arrayEmpresas = respuesta.empresas;
          //Obtiene todos los empresas asociados al usuario seleccionado
          this.empresas = respuesta.my_empresas;
        }).catch(function (error) {
          console.log(error);
        })

      },
      AgregarEmpresas() {
       let me = this;
       axios.post('usuarios/agregarEmpresasUsuario/'+me.user.user_id,{
         'empresas' : me.empresas,
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
      this.listarUsuarios(1, this.buscar, this.criterio)
    }
  }
</script>
<style>
  .padd{
    padding: 0px 0px;
  }
</style>