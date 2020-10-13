<template>
    <div>
        
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
        }
    },
    methods:{
        listPer(){
            let mee = this;
            var url = "/persona";
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayDatos = respuesta.personas.data;
            })
            .catch(function(error){
                console.log(error);
            })
        },
        regPer(){
            let mee = this;
            var url = "/persona/registrar";
            axios.post(url,{
                nombre:this.nombre
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
            let mee = this;
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
            let mee = this;
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
        console.log('component mounted.')
        this.listPer(1,this.criterio,this.buscar);
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