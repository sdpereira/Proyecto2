<template>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-book"></i>Cliente
                    <button type="button" class="btn btn-primary" data.toggle="modal" @click="abrirModal('guardar')">
                        <i class="icon-plus"></i>&nbsp;Agregar
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="objeto in arrayDatos" :key="objeto.id">
                                <td v-text="objeto.nombre"></td>
                                <td v-text="objeto.telefono"></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data.toggle="modal" @click="abrirModal('editar',objeto)">
                                        <i class="icon-pencil"></i>
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-danger" data.toggle="modal" @click="eliminarCliente(objeto)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalNuevo" :class="{'mostrar' :modal}">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-tittle" v-text="titulo"></h4>
                        <button type="button" class="close" @click="cerrarModal">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" id="nombre" name="nombre" class="form-control" placeholder="ingrese el nombre">
                                    <span>Ingrese nombre</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal" class="btn btn-secondary" data.dismiss="modal">Cerrar</button>
                        <button v-show="accion==0" type="button" @click="regCliente" class="btn btn-primary" >Guardar</button>
                        <button v-show="accion" type="button" @click="actCliente" class="btn btn-primary" >Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
export default {
    data() {
        return {
            arrayDatos:[],
            nombre:"",
            idCat:0,
            modal:0,
            accion:0,
            titulo:"",
            buscar:"",
            criterio:"nombre",
        }
    },
    methods:{
        listCat(){
           let me = this;
           var url ="/categoria";
           axios.get(url).then(function(response){
               var respuesta = response.data;
               me.arrayDatos = respuesta.categorias.data;
           })
           .catch(function(error){
               console.log(error)
           })
        },
        regCat(){
           let me = this;
           var url ="/categoria/registrar";
           axios.post(url,{
               nombre:this.nombre
           })
           .then(function(response){
               alert('se gurado correctamente');
               me.listCat();
           })
           .catch(function(error){
               console.log(error)
           })
        },
        actCat(){
           let me = this;
           var url ="/categoria/actualizar";
           axios.put(url,{
               id:this.idCat,
               nombre:this.nombre
           })
           .then(function(response){
               alert('se actualizo correctamente');
               me.listCat();
               me.cerrarModal();
           })
           .catch(function(error){
               console.log(error)
           })
        },
        eliminaCat(data=[]){
           let me = this;
           var url ="/categoria/actualizar";
           axios.post(url,{
               id:data['id']
           })
           .then(function(response){
               alert('se elimino correctamente');
               me.listCat();   
           })
           .catch(function(error){
               console.log(error)
           })
        },
        abrirModal(accion,data=[]){
            switch (accion) {
                case 'guardar':
                    this.titulo = 'registrar categoria';
                    this.accion = 0;
                    this.limpiar();
                    break;
                case 'editar':
                    this.titulo = 'editar categoria';
                    this.accion = 1;
                    this.idCat = data['id'];
                    this.nombre = data['nombre'];
                    break;
                default:
                    break;
            }
            this.modal=1;
        },
        cerrarModal(){
            this.modal = 0;
        },
        limpiar(){
            this.nombre = "";
        }
    },
    mounted(){
        console.log('component mounted.');
        this.listCat(1,this.criterio,this.buscar);
    }
}
</script>
<style>
    .modal-content{
       width: 100% !important;
       position: absolute !important;
    }
    .mostrar{
       display: list-item !important;
       opacity: 1 !important;
       position: absolute !important;
    }
</style>