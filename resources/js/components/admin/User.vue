<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <button class="btn btn-light btn-block" type="button" @click="addnew">
                                    Create new Staff
                                </button>
                                <div class="mail-list mt-4">
                                    <a href="#" class="active"><i class="mdi mdi-lock-open-check mr-2"></i> Active <span class="ml-1 float-right">(18)</span></a>
                                    <a href="#"><i class="mdi mdi-lock-clock mr-2"></i>Inactive</a>
                                    <a href="#"><i class="mdi mdi-lock-alert mr-2"></i>Disabled</a>
                                    <a href="#"><i class="mdi mdi-lock-outline mr-2"></i>Retired</a>
                                </div>

                                <h6 class="mt-4">Labels</h6>

                                <div class="mail-list mt-1">
                                    <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-info float-right"></span>Active</a>
                                    <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-warning float-right"></span>Disabled</a>
                                    <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-primary float-right"></span>Retired</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-4 col-sm-6 form-inline">
                                </div>
                                <div class="col-xl-8 col-sm-6">
                                    <form class="float-sm-right form-inline">
                                        <div class="search-box">
                                            <div class="position-relative">
                                                <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch">
                                                <i class="icofont icofont-search-user search-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name / Role</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr  v-for="user in users" v-bind:key="user.id">
                                            <td >
                                                <div class="avatar-xs" v-if="user.avatar == 'n/a'">
                                                    <span class="avatar-title rounded-circle">{{user.firstname.charAt(0)}}</span>
                                                </div>
                                                <div v-else>
                                                    <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+user.avatar" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{user.firstname}} {{user.lastname}}</a></h5>
                                                <p class="text-muted mb-0">{{user.type}}</p>
                                            </td>
                                            <td class="text-center">{{user.email}}</td>
                                            <td class="text-center">
                                                <span v-if="user.status == 'Active'" class="badge badge-success font-size-12">Active</span>
                                                <span v-else-if="user.status == 'Inactive'" class="badge badge-secondary font-size-12">Inactive</span>
                                                <span v-else-if="user.status == 'Disabled'" class="badge badge-warning font-size-12">Disabled</span>
                                                <span v-else class="badge badge-danger font-size-12">Retired</span>
                                            </td>
                                            <td class="text-center">{{user.created_at}}</td>
                                            <td class="text-center">
                                                <a class="mr-3 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class='bx bx-show'></i></a>
                                                <a class="mr-3 text-warning" @click="edit(user)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                                <a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bx-trash'></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Staff Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <form @submit.prevent="create">
                                <div class="modal-body">
                                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                                        <div class="col-md-4">
                                            <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="jpeg">
                                            </myUpload>
                                            <div @click="toggleShow" class="fuzone" style="width: 310px; height: 310px;">
                                                <div v-if="photo.url != ''">
                                                    <img :src="photo.url" style="width: 300px; height: 300x;">
                                                </div>
                                                <div v-else class="fu-text" @click="toggleShow">
                                                    <span><i class="fa fa-picture"></i> Click here to upload<br> <span
                                                            v-if="errors.avatar"
                                                            style="color: red; font-size: 12px; margin-top: -20px;">
                                                            ({{ errors.avatar[0] }})</span></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8" style="margin-top: 15px;">
                                            <div class="form-group row customerform">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="formrow-firstname-input">Firstname <span v-if="errors.firstname" class="haveerror">({{ errors.firstname[0] }})</span></label>
                                                        <input type="firstname" class="form-control" id="formrow-firstname-input" v-model="user.firstname" style="text-transform: capitalize;">
                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="formrow-firstname-input">Lastname <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                                        <input type="lastname" class="form-control" id="formrow-lastname-input" v-model="user.lastname" style="text-transform: capitalize;">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row customerform">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="formrow-email-input">Email <span v-if="errors.email" class="haveerror">({{ errors.email[0] }})</span></label>
                                                        <input type="email" class="form-control" id="formrow-email-input" v-model="user.email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label>Birthday <span v-if="errors.birthday" class="haveerror">({{ errors.birthday[0] }})</span></label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" v-model="user.birthday" placeholder="dd M, yyyy"  data-date-format="dd M, yyyy" data-provide="datepicker">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row customerform">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="formrow-email-input">User Type <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                                        <multiselect v-model="user.type" :options="options" group-values="libs"
                                                        group-label="language" placeholder="Select Usertype" track-by="name"
                                                        :allow-empty="false"
                                                        deselect-label="Can't remove"
                                                        @input="onChange(user.type)"
                                                        label="name"></multiselect>
                                                    </div>
                                                </div>
                                                 <div class="col-md-6" style="margin-top: 5px;">
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="customRadio1" class="custom-control-input" checked="checked" value="Male" v-model="user.gender">
                                                        <label class="custom-control-label" for="customRadio1">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="customRadio2" class="custom-control-input" checked="checked" value="Female" v-model="user.gender">
                                                        <label class="custom-control-label" for="customRadio2">Female</label>
                                                    </div>
                                                </div>

                                                 <div class="col-sm-12" v-if="show == true">
                                                    <div class="form-group form-primary">
                                                         <label for="formrow-email-input">Laboratory <span v-if="errors.laboratory" class="haveerror">({{ errors.laboratory[0] }})</span></label>
                                                        <multiselect v-model="user.laboratory" :options="laboratories" placeholder="Select Laboratory" label="name" track-by="id">
                                                        </multiselect>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import myUpload from 'vue-image-crop-upload/upload-2.vue';
    import Multiselect from 'vue-multiselect'
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                keyword: '',
                laboratories: [],
                users : [],
                user: {
                    id: '',
                    firstname: '',
                    lastname: '',
                    gender: '',
                    birthday: '',
                    avatar: '',
                    type: '',
                    laboratory: ''
                },
                options: [{
                    language: 'Finance Users',
                        libs: [{
                                name: 'Accountant'
                            },
                            {
                                name: 'Cashier'
                            }
                        ]
                    },
                    {
                        language: 'Laboratory Users',
                        libs: [{
                                name: 'Customer Relations Officer'
                            },
                            {
                                name: 'Lab Manager'
                            },
                            {
                                name: 'Lab Analyst'
                            }
                        ]
                    }
                ],
                photo: {
                    show: false,
                    url: '',
                    signature: '',
                },
                params: {
                    token: '123456798',
                    name: 'avatar'
                },
                headers: {
                    smail: '*_~'
                },
                editable : false,
                show : false

            }
        },

        created(){
            this.fetch();
            this.fetchLaboratory();
        },

        methods : {
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            fetchLaboratory() {
                axios.get(this.currentUrl + '/request/admin/dd/active/' + 'Laboratory')
                .then(response => {
                    this.laboratories = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetch(page_url) {
                let vm = this;
                    axios.post(this.currentUrl + '/request/admin/users', {
                        word: this.keyword,
                    })
                    .then(response => {
                        this.users = response.data.data;
                        vm.makePagination(response.data.meta, response.data.links);
                    })
                    .catch(err => console.log(err));
            },

            create() {
                if (this.editable === false) {
                    let usertype = (this.user.type != null) ? this.user.type.name : '';
                     axios.post(this.currentUrl + '/request/admin/user/store', {
                        firstname: this.user.firstname,
                        lastname: this.user.lastname,
                        email: this.user.email,
                        gender: this.user.gender,
                        birthday: this.user.birthday,
                        type: usertype,
                        laboratory: (this.user.laboratory) ? this.user.laboratory.id : '',
                        avatar: this.photo.url
                    })
                    .then(response => {
                        this.fetch();
                        $("#new").modal("hide");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                } else {
                    axios.put(this.currentUrl + '/request/admin/user/store', {
                        id: this.user.id,
                        firstname: this.user.firstname,
                        lastname: this.user.lastname,
                        email: this.user.email,
                        gender: this.user.gender,
                        birthday: this.user.birthday,
                        type: this.user.type.name,
                        laboratory: this.user.laboratory.id,
                        avatar: this.photo.url
                    })
                    .then(response => {
                        this.editable = false;
                        let page_url = '/request/admin/users?page=' + this.pagination.current_page;
                        this.fetch(page_url);
                        $("#new").modal("hide");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                }
            },

            edit(user) {
                this.editable = true;
                this.user.id = user.id;
                this.user.firstname = user.firstname;
                this.user.lastname = user.lastname;
                this.user.email = user.email;
                this.user.birthday = user.birthday;
                this.user.gender = user.gender;
                this.user.type = {
                    'name': user.type
                };
                this.user.laboratory = user.laboratory;
                $("#new").modal("show");
            },

            addnew(){
                this.user = {};
                this.photo.url = '';
                $("#new").modal("show");
            },

            toggleShow() {
                this.photo.show = !this.photo.show;
            },

            cropSuccess(imgDataUrl, field) {
                this.photo.url = imgDataUrl;
            },

            onChange(type){
                if(type.name == 'Lab Analyst' || type.name == 'Customer Relations Officer' || type.name == 'Lab Manager'){
                    this.show = true;
                }else{
                    this.show = false;
                }
            }

        },

        components: { Multiselect, myUpload }
        
    }
</script>