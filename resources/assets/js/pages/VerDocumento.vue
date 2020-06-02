<template>
    <div> 
      <div class="col-12">
        <card>
          <div slot="header"> 
            <span class="card-title font-weight-normal font-weight-light text-white small">DATOS DEL DOCUMENTO</span>
          </div>
          <div>
              <h4 class="title" v-text="datos.tipo+' Nº '+datos.numero_documento+' - '+datos.creador">
                <br>
               
              </h4>
               <p class="card-category" v-text="'El documento fue creado el '+datos.fecha_documento"></p>
            <p class="description text-center">
              
            </p>
          </div>
          <div class="text-left">
            <table class="table table-hover">
                <tbody>
                    <tr>
                      <th>Firma/Remitente:</th>
                        <td v-text="datos.remitente"></td>
                    </tr>
                    <tr>
                      <th>Asunto:</th>
                        <td v-text="datos.asunto"></td>
                    </tr>
                    <tr>
                      <th>Detalle:</th>
                        <td v-text="datos.detalle"></td>
                    </tr>

                     <tr>
                      <th>Archivador:</th>
                        <td>
                          <!-- <span v-text="datos.archivador"></span> -->
                          <h5 v-if="datos.archivador"><span class="badge badge-warning text-white" v-text="datos.archivador"></span></h5>
                        </td>
                    </tr>
                   
                     <tr>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
          </div>
        </card>
      </div>

        <hr/>

        <card>
        <div slot="header">
          <span class="card-title font-weight-normal font-weight-light text-white small">HISTORIAL DEL DOCUMENTO</span>
        </div>

         <div class="row">
          <div class="table-responsive">
            <el-table stripe style="width: 100%;" :data="datos.datos">
              <el-table-column prop="fecha_creado" minWidth= 70 label="Fecha"></el-table-column>
               <el-table-column prop="hora" minWidth= 40 label="Hora"></el-table-column>
              <el-table-column  minWidth= 60 label="Estado">
                <template slot-scope="{row}">
                  <!-- MIENTRAS EL DOCUMENTO NO ESTE ARCHIVADO (ESTADO 3) Y EL DESTINO SEA DISTINTO AL DEPTO DEL USER EN SESIÒN SE MOSTRARÀ EL ESTADO DERIVADO -->
                  <div v-if="row.auth_depto_id != row.destino_id && row.estado_id != 3">
                    <span  class="badge badge-info text-white">{{"DERIVADO".toUpperCase()}}</span>
                  </div>
                  <div v-else>
                    <span v-if="row.estado_id === 1" class="badge badge-warning text-white">{{row.estado.toUpperCase()}}</span>
                    <span v-if="row.estado_id === 2" class="badge badge-danger text-white">{{row.estado.toUpperCase()}}</span>
                    <span v-if="row.estado_id === 3" class="badge badge-success text-white">{{row.estado.toUpperCase()}}</span>
                  </div>
                </template>
              </el-table-column>
              <el-table-column prop="origen" minWidth= 90 label="Origen"></el-table-column>
              <el-table-column prop="destino" minWidth= 90 label="Destino"></el-table-column>
              <el-table-column prop="proveido" minWidth= 120 label="Detalle"></el-table-column>
            </el-table>
          </div>
      </div>
        </card>
    </div>


</template>

<script>
  import {DatePicker, Dialog, Table, TableColumn, Select, Option, Notification} from 'element-ui'
  import swal from 'sweetalert2'
  import LSwitch from '@/components/Switch.vue'
  import LPagination from '@/components/Pagination.vue'
  import {FadeRenderTransition } from '@/components/index'
  import moment from 'moment'
 
  export default{
       props: [
        'datos',
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
      FadeRenderTransition,
    },

    data () {
      return {
      }

    },
   
    methods: {

        prueba(){

            // console.log(this.datos.datos)        
            }

        },

    mounted() {

}

  }
</script>
<style>
.form-group {
    margin-bottom: 1rem;
}

.card-header:first-child {
    background:#132039;
    padding: 10px;
    width: 100%;
}
</style>