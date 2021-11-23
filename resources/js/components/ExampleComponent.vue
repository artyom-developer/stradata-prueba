<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.')
            this.loadTest()
        },
        methods:{
          loadTest(){              
              const formData = {
                  hola:"Prueba"
              }
              axios.post("api/Categoria/add",formData)
              .then(response => {
                  alert(JSON.stringify(response.data))
                })
                .catch(error => {
                  alert(error.message)
                })
          }
        }
    }
</script>
