<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Buscador</div>

                    <div class="card-body" v-if="token==null">

                        <div class="form-row row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" v-model="campoEmail" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" max="100" min="1" v-model="campoPassword">
                            </div> 
                            <div class="form-group col-md-4">
                                <br/>
                                <button type="submit" class="btn btn-secondary" v-if="isLoading">Ingresando...</button>
                                <button type="submit" class="btn btn-primary" v-on:click="login()" v-else>Entrar</button>
                                                            
                            </div>
                        </div>

                    </div>

                    <div class="card-body" v-else>
                        
                        <div class="form-row row">
                            <div class="form-group col-md-4">
                            <label for="inputEmail4">Nombres y apellidos</label>
                            <input type="text" class="form-control" v-model="campoNombre" >
                            </div>
                            <div class="form-group col-md-4">
                            <label for="inputPassword4">Porcentaje coincidencia</label>
                            <input type="number" class="form-control" max="100" min="1" v-model="campoPorcentaje">
                            </div> 
                            <div class="form-group col-md-4">
                                <br/>
                                <button type="submit" class="btn btn-secondary" v-if="isLoading">Procesando...</button>
                                <button type="submit" class="btn btn-primary" v-on:click="buscarCoincidencias()" v-else>Buscar</button>
                                                            
                            </div>
                        </div>

                    
                    <div v-show="success&&listaResultados.length>=1" class="alert alert-success alert-dismissible fade show" role="alert">
                        Exitoso con resultados!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div  v-show="success&&listaResultados.length==0" class="alert alert-warning alert-dismissible fade show" role="alert">
                         Exito sin resultados
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <hr/> 

                    <table class="table">
                        <thead>
                            <tr> 
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo persona</th>
                                <th scope="col">Tipo cargo</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Municipio</th>
                                <th scope="col">% Coincidencia</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr v-show="isLoading==false&&listaResultados.length==0&&campoNombre.length>=3"> 
                                <td colspan="6">No se encontraron coincidencias</td>  
                            </tr> 
                            <tr v-show="isLoading"> 
                                <td colspan="6">Cargando...</td>  
                            </tr> 
                            <tr v-for="item in listaResultados"> 
                                <td>{{item.nombre}}</td> 
                                <td>{{item.tipo_persona}}</td> 
                                <td>{{item.tipo_cargo}}</td> 
                                <td>{{item.departamento}}</td> 
                                <td>{{item.municipio}}</td> 
                                <td>{{parseInt(item.coincidencia)}}%</td> 
                            </tr> 
                        </tbody>
                    </table>

                    <hr/>

                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-info" v-on:click="dataPaginate.prev_page_url?consultar(dataPaginate.prev_page_url):null">Anterior</button>
                        <button type="button" class="btn btn-outline-info" v-on:click="dataPaginate.next_page_url?consultar(dataPaginate.next_page_url):null">Siguiente</button> 
                    </div>
  
  
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
            campoNombre:"",
            listaResultados:[],
            campoPorcentaje:"",
            isLoading:false,
            dataPaginate:{},
            success:false,
            token:null,
            campoEmail:"",
            campoPassword:""
          }
        },
        mounted() {
             
        },
        methods:{
          login(){
              const formData = {
                  name:"Usuario prueba",
                  email: this.campoEmail,
                  password:this.campoPassword,
                  password_confirmation:this.campoPassword
              } 
              
              this.isLoading = false

              axios.post("api/login",formData)
              .then(response => {
                  this.isLoading = false
                  const res = response.data
                  console.log(res) 
                  this.token = res.token
              })
              .catch(error => {
                  this.isLoading = false 
                 alert(error.message)
              })
          },
          buscarCoincidencias(){              
              this.consultar("api/persona/buscar-coincidencia")
          },
          consultar(url){
              const formData = {
                  nombre_buscado: this.campoNombre,
                  porcentaje_buscado:this.campoPorcentaje
              }
              this.isLoading = true
              this.listaResultados = []
              this.success = false
              axios.post(url,formData,{
                headers: { Authorization: `Bearer ${this.token}` }
              })
              .then(response => {
                  this.isLoading = false
                  console.log(response)
                  const res = response.data
                  if(res.success){
                      this.listaResultados = res.data.data
                      this.dataPaginate = res.data
                  }
                  else{
                      alert("Error al consultar la BD")
                  }
                  this.success = true
              })
              .catch(error => {
                  this.isLoading = false
                 alert(error.message)
              })
          }
        }
    }
</script>
