

<template>
    <main class="main">
        <ol class="breadcrumb">
            <i class="fa-fa-book">Home</i>
        </ol>
        <div class="container-fluid">
            <div class="card">                
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data.toggle="modal" @click="abrirModal('guardar')">
                        <i class="icon-plus"></i>&nbsp;Agregar
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm" >
                        <thead>
                            <tr>
                                <th>Cc</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Nombre area</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="objeto in arrayDatos" :key="objeto.id">
                                <td v-text="objeto.cc"></td>
                                <td v-text="objeto.nombre"></td>
                                <td v-text="objeto.apellidos"></td>
                                <td v-text="objeto.nomArea"></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data.toggle="modal" @click="abrirModal('editar',objeto)">
                                        <i class="icon-pencil"></i>
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" data.toggle="modal" @click="eliminarPer('objeto')">
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
                        <h4 class="modal-tittle " v-text="titulo"></h4>
                        <button type="button" class="close" @click="cerrarModal">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="input-text">Cc</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cc" id="cc" name="cc" class="form-control" placeholder="ingrese su cc" >
                                    <span>Ingrese su cc</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="input-text">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" id="nombre" name="nombre" class="form-control" placeholder="ingrese su nombre" >
                                    <span>Ingrese su nombre</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="input-text">Apellidos</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellidos" id="apellidos" name="apellidos" class="form-control" placeholder="ingrese su apellidos" >
                                    <span>Ingrese su apellidos</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="input-text">Nombre</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idArea" >
                                        <option v-for="objeto in arrayAreas" :key="objeto.id" :value="objeto.id" v-text="objeto.nombre"></option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal" class="btn btn-secondary" data.dismiss="modal">Cerrar</button>
                        <button v-show="accion==0" type="button" @click="regPer" class="btn btn-primary">Guardar</button>
                        <button v-show="accion" type="button" @click="actPer" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
export default {
    data(){
        return{
            arrayDatos:[],
            nombre: "",
            cc:"",
            apellidos:"",            
            idPer: 0,
            modal: 0,
            accion: 0,
            titulo: "",
            buscar: "",
            criterio: 'nombre',
            arrayAreas:[],
            idArea:0
        }
    },
    methods:{
        listPer(){
            let me = this;
            var url = "/persona";
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayDatos = respuesta.personas;
            })
            .catch(function(error){
                console.log(error);
            })
        },
        getArea(){
            let me = this;
            var url = "/selectarea";
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayAreas = respuesta.areas;
            })
            .catch(function(error){
                console.log(error);
            })
        },
        regPer(){
            let me = this;
            var url = "/persona/registrar";
            axios.post(url,{
                cc:this.cc,
                nombre:this.nombre,
                apellidos:this.apellidos,
                idArea:this.idArea
            })
            .then(function(response){
                alert("se registro correctamente");
                me.listPer();
            })
            .catch(function(error){
                console.log(error);
            })
        },
        actPer(){
            let me = this;
            var url = "/persona/actualizar";
            axios.put(url,{
                id:this.idPer,
                nombre:this.nombre
            })
            .then(function(response){
                alert("se actualizo correctamente");
                me.listPer();
                me.cerrarModal();
            })
            .catch(function(error){
                console.log(error);
            })
        },
        eliminarPer(data=[]){
            let me = this;
            var url = "/persona/eliminar";
            axios.post(url,{
                id:data["id"]        
            })
            .then(function(response){
                alert("se elimino correctamente");
                me.listPer();
            })
            .catch(function(error){
                console.log(error);
            })
        },
        abrirModal(accion,data=[]){
            switch (accion) {
                case "guardar":
                    this.titulo = "registrar persona";
                    accion = 0;
                    this.limpiar();
                    break;
                case "editar":
                    this.titulo = "editar persona";
                    this.accion = 1;
                    this.idPer = data['id'];
                    this.cc = data['cc'];
                    this.nombre = data['nombre'];
                    this.apellidos = data['apellidos'];
                    this.id_area = data['id_area'];
                    break;
                default:
                    break;
            }
            this.modal = 1;
        },
        cerrarModal(){
            this.modal = 0;
        },
        limpiar(){
            this.nombre = "";
        }
    },
    mounted(){
        // console.log('component mounted.')
        this.getArea();
        this.listPer();
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