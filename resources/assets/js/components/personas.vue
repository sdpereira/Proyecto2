<template>
    <div id="app" class="container">
    <div class="card-body">
        <label >Nombre</label>
        <input type="text">
        <h5>Área</h5>
        <select v-model="idArea" >
            <option v-for="objeto in arrayAreas" :key="objeto.id" :value="objeto.id" v-text="objeto.nombre"></option>
        </select>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Área</th>
                </tr>
            </thead>
            <tbody v-if="this.arrayDatos.length">
                <tr v-for="objeto in arrayDatos" :key="objeto.id">
                    <td v-text="objeto.nombre"></td>
                    <td v-text="objeto.apellidos"></td>
                    <td v-text="objeto.nomArea"></td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr >
                    <td colspan="3" >NO Existen Datos</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            arrayDatos:[],
            nombre: "",
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
                nombre:this.nombre,
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
            var url = "/persona/actualizar";
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
                    this.idPer = data["id"];
                    this.nombre = data["nombre"];
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