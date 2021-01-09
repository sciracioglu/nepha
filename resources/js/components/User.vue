<template>
    <div>
      <div class="list-group">
        <div class="list-group-item" v-for="(user,index) in users" :key="index">
          <div class="row">
            <div class="col-md-4">{{ user.name }}</div>
            <div class="col-md-7">{{ user.email }}</div>
            <div class="col-md-1 text-right">
                <a href="javascript:void(0);" @click="deleteUser(user.id)" class="btn btn-sm btn-danger btn-icon waves-effect waves-themed">
                  <i class="fal fa-trash"></i>
                </a>
            </div>
          </div>
        </div>
        <div class="list-group-item">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model='form.name' />
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label>E-mail</label>
                <input type="text" class="form-control" v-model='form.email' />
              </div>
            </div>
            <div class="col-md-1 text-right">
              <div class="form-group">
                <label style="display:block">&nbsp;</label>
                <a href="javascript:void(0);" @click="save()" class="btn btn-primary btn-icon waves-effect waves-themed">
                  <i class="fal fa-save"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
export default{
    data(){
        return {
          users:[],
          form:new Form({
            name:null,
            email:null,
          }),
        }
    },
    mounted(){
      this.getUsers();
    },
    methods:{
      getUsers(){
        var self = this;
        axios.get('/user-list')
          .then(({data})=>{
            self.users = data;
          })
      },
      save(){
        var self = this;
        this.form.post('/user')
          .then(function(){
            self.getusers();
          })
      },
      deleteUser(id){
        var self = this;
        Swal.fire({
          title: 'Emin misniz?',
          text: "Kullanıcı Silinecek!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Evet !',
          cancelButtonText: 'Hayır'
          }).then((result) => {
              if (result.isConfirmed) {
                  axios.delete('/user/' + id)
                      .then(function(){
                          self.getUsers();
                      });
              }
          });
      }
    }
}
</script>