<template>
    <div>
        <div class="list-group">
            <div class="list-group-item list-group-item-primary">
                <div class="row">
                    <div class="col-md-4">Kullanıcı Adı</div>
                    <div class="col-md-4">Mail Adresi</div>
                    <div class="col-md-3">Yetkisi</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="list-group-item" v-for="(user,index) in users" :key="index" v-if="user.email !== 'serkan@tedankara.k12.tr'">
                <div class="row">
                    <div class="col-md-4">{{ user.name }}</div>
                    <div class="col-md-4">{{ user.email }}</div>
                    <div class="col-md-3">{{ user.role == 2 ? 'Yönetici' : 'Kullanıcı' }}
                        <a href="#" @click="changePerm(user)"><i class="fal fa-send-back"></i></a>
                    </div>
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
                            <label>Kullanıcı Adı</label>
                            <input type="text" class="form-control" v-model='form.name'/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mail Adresi</label>
                            <input type="text" class="form-control" v-model='form.email'/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Yetkisi</label>
                            <select v-model='form.role' class="form-control">
                                <option value="1">Kullanıcı</option>
                                <option value="2">Yönetici</option>
                            </select>
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

export default {
    data() {
        return {
            users: [],
            form: new Form({
                name: null,
                email: null,
                role: null,
            }),
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            let self = this;
            axios.get('/user-list')
                .then(({data}) => {
                    self.users = data;
                })
        },
        save() {
            let self = this;
            this.form.post('/user')
                .then(function () {
                    self.getusers();
                })
        },
        changePerm(user) {
            let self = this;
            Swal.fire({
                title: 'Emin misniz?',
                text: "Kullanıcı Yetkisi Değişecek!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet !',
                cancelButtonText: 'Hayır'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.patch('/user/' + user.id)
                        .then(function () {
                            self.getUsers();
                        });
                }
            });
        },
        deleteUser(id) {
            let self = this;
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
                        .then(function () {
                            self.getUsers();
                        });
                }
            });
        }
    }
}
</script>
