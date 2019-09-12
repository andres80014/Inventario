<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Categorías
                <button type="button" class="btn btn-secondary"  @click="abrirModal('categoria','registrar')">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="opcionBuscar">
                                <option value="nombre">Nombre</option>
                                <option value="descripcion">Descripción</option>
                            </select>
                            <input type="text" v-model="textBuscar" @keyup.enter="listarCategoria(textBuscar,opcionBuscar)" class="form-control" placeholder="Texto a buscar">
                            <button class="btn btn-primary" type="submit" @click="listarCategoria(textBuscar,opcionBuscar)"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in arrayCategoria " :key="categoria.id">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('categoria','actualizar',categoria)">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="categoria.condicion==1">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                                    </template>
                                    <template v-if="categoria.condicion==0">
                                    <button type="button" class="btn btn-info btn-sm" @click="activarCategoria(categoria.id)">
                                        <i class="icon-like"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="categoria.nombre"></td>
                            <td v-text="categoria.descripcion"></td>
                            <td>
                                <div v-if="categoria.condicion">
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Desactivado</span>
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#">Ant</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>



    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" :class="{'mostrar':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tutiloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="text-input" placeholder="Nombre de categoría">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                            <div class="col-md-9">
                                <input type="text" v-model="descripcion" name="descripcion" class="form-control" placeholder="Ingrese descripción">
                            </div>
                        </div>
                        <div class="form-group row div-error" v-show="errorCategoria">
                            <div class="text-center  text-error">
                                <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrarCategoria">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="actualizarCategoria">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
</main>
</template>
<script>
export default {
    data(){
        return {
            categoria_id : 0,
            nombre:'',
            descripcion:'',
            arrayCategoria: [],
            modal: 0, 
            tutiloModal :'',
            tipoAccion: 0,
            errorCategoria: '',
            errorMostrarMsjCategoria:[],
            textBuscar:'',
            
        }
    },
    methods:{
        listarCategoria(textBuscar,opcionBuscar){
            let me = this;
            var url = '/categorias?textBuscar=' + textBuscar + '&opcionBuscar=' + opcionBuscar;
            axios.get(url)
            .then(function (response) {
            // handle success
            me.arrayCategoria = response.data;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function () {
            // always executed
            });
        },
        registrarCategoria(){
            
            if(this.validarCategoria() != 0){
                 return false;   
            }
            else{
                let me = this;
                axios.post('/categoria/registrar', {
                    'nombre': me.nombre,
                    'descripcion': me.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria('','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },

        actualizarCategoria(){
            
            if(this.validarCategoria() != 0){
                 return false;   
            }
            else{
                let me = this;
                axios.post('/categoria/actualizar', {
                    'id':me.categoria_id,
                    'nombre': me.nombre,
                    'descripcion': me.descripcion

                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria('','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        desactivarCategoria(id){
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Estas eguro de desactivar?',
            //text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                
                let me = this;
                 console.log(id);
                axios.post('/categoria/desactivar', {
                    'id':id,
                   
                })
                .then(function (response) {
                    me.listarCategoria('','nombre');
                    swalWithBootstrapButtons.fire(
                    'Desactivado!',
                    'Su categoria se desactivo correctamente',
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
               
               /* mensaje si se cancela 
               swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
                */
            }
            })
        },
        activarCategoria(id){
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Esta seguro de activar esta Categoria?',
            //text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                
                let me = this;
                 console.log(id);
                axios.post('/categoria/activar', {
                    'id':id,
                   
                })
                .then(function (response) {
                    me.listarCategoria('','nombre');
                    swalWithBootstrapButtons.fire(
                    'Activada!',
                    'Su categoria se activo correctamente!',
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });
                
            } else if (
                
                result.dismiss === Swal.DismissReason.cancel
            ) {
                }
            })
        },
        validarCategoria(){
            this.errorCategoria = 0;
            this.errorMostrarMsjCategoria=[];
            if(!this.nombre){
                this.errorMostrarMsjCategoria.push("El nombre de la categoria no puede ser vacio");
                this.errorCategoria=1;
            } 
            return this.errorCategoria;
        },
        abrirModal(modelo,accion,data=[]){
            
            switch(modelo){
                case 'categoria' : 
                {
                    switch(accion){
                        case 'registrar':
                        {
                            this.tutiloModal = "Registrar Categoria"
                            this.errorMostrarMsjCategoria =[];
                            this.modal = 1;
                            this.nombre = '';   
                            this.descripcion = '';             
                            this.tipoAccion = 1;
                            break;
                        }
                        case 'actualizar':
                        {
                            this.tutiloModal = "Actualizar Categoria"
                            this.errorMostrarMsjCategoria =[];
                            this.modal = 1;
                            this.tipoAccion = 2;
                            this.categoria_id = data['id'];
                            this.nombre = data['nombre'];   
                            this.descripcion = data['descripcion'];  
                            break;
                        }
                    }
                }
            }
        },
        cerrarModal(){
            this.modal = 0;
            this.tutiloModal = '';
            this.nombre = '';
            this.descripcion = '';
        }
    },
    mounted() {
        this.listarCategoria(this.textBuscar,this.opcionBuscar);
    },
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
    background-color: #3c29297a !important;
}
.div-error{
    display: flex;
    justify-content: center;
}

.text-error{
    color: red;
    font-weight: bold;
}
</style>
