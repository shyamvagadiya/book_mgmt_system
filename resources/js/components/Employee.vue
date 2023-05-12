<template>
    <div class="container p-5">
        <button type="button" class="btn btn-primary mb-4 float-right" data-toggle="modal" data-target="#myModal">New Book</button>

        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted"  v-if="bookId == ''">Add New Book</h5>
                        <h5 class="modal-title text-muted"  v-else>Update Book</h5>

                        <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-sm text-danger" if="errors != ''">
                            <p v-for="error in errors" :key="error"><small>{{error}}</small></p>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="form.title">
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" class="form-control" v-model="form.author">
                        </div>
                        <div class="form-group">
                            <label>Genre</label>
                            <input type="text" class="form-control" v-model="form.genre">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" v-model="form.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" class="form-control" v-model="form.isbn">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" @change='uploadPhoto' v-el:file ref="form.imageReset" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Published</label>
                            <input type="text" class="form-control" v-model="form.published">
                        </div>
                        <div class="form-group">
                            <label>Publisher</label>
                            <input type="text" class="form-control" v-model="form.publisher">
                        </div>
                        <div class="form-group mt-2" v-if=form.imgshow>
                            <img :src="form.imgshow" width="150" height="150" alt="">
                        </div>

                        <button v-if="bookId == ''" type="button" class="btn btn-primary" @click="storeBook">Submit</button>
                        <button v-else type="button" class="btn btn-primary" @click="updateBook">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mt-2">
                    <input type="text" class="form-control" placeholder="Search" v-model="search">
                </div>        
            </div>
        </div>
        <table class="table table-bordered table-hover mt-2">
                <thead>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Description</th>
                    <th>ISBN</th>
                    <th>Image</th>
                    <th>Published</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr v-for="book in books.data" :key="book.id">
                            <td>{{book.title}}</td>
                            <td>{{book.author}}</td>
                            <td>{{book.genre}}</td>
                            <td>{{book.description}}</td>
                            <td>{{book.isbn}}</td>
                            <td><img :src="book.image" height="100" width="100"></td>
                            <td>{{book.published}}</td>
                            <td>{{book.publisher}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal" @click="editBook(book)">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger"  @click="deleteBook(book)">Delete</button>
                            </td>
                        </tr>
                </tbody>
                <Bootstrap5Pagination 
                            :data="books"
                            @pagination-change-page="getBooksFromMethod"
                        />
        </table>
        
    </div>
</template>
<script >
import { ref,onMounted, reactive } from 'vue';
import { Bootstrap5Pagination  } from 'laravel-vue-pagination';

import axios from 'axios'
export default{
    setup(){
        const books=ref({});
        const errors=ref([]);
        const bookId=ref([]);
        const form=reactive({
            title:'',
            author:'',
            genre:'',
            description:'',
            isbn:'',
            image:'',
            published:'',
            publisher:'',
            imageReset:null,
            imgshow:null

        })
        // const getBooksInit = async () => {
        //     getBooks()
        // }
        // const getBooks=async(page = 1)=>{
        //     let res = await axios.get(`api/books?page=${page}`);
        //     books.value = res.data;
        // }
        // const storeBook=async(e)=>{

        //     axios.post('api/books', form)
        //     .then((response) => {
        //         getBooks()
        //         formReset()
        //         $('#myModal').modal("hide")
        //     })
        //     .catch((err) => {
        //         console.log("Checker",err)
        //         var data=[]
        //         for(const key in err.response.data.errors)
        //         {
        //             data.push(err.response.data.errors[key][0])
        //         }  
        //         errors.value = data
        //     })
        // }

        // const updateBook=async(e)=>{

        //     axios.post('api/update/books/'+bookId.value, form)
        //     .then((response) => {
        //         getBooks()
        //         formReset()
        //         $('#myModal').modal("hide")
        //     })
        //     .catch((err) => {
        //         console.log("Checker",err)
        //         var data=[]
        //         for(const key in err.response.data.errors)
        //         {
        //             data.push(err.response.data.errors[key][0])
        //         }  
        //         errors.value = data
        //     })
        // }

        // const deleteBook=async(e)=>{
        //     axios.post('api/destroy/books/'+e.id, form)
        //     .then((response) => {
        //         getBooks()
        //         formReset()
        //     })
        //     .catch((err) => {
        //         console.log("Checker",err)
        //     })
        // }

        

        // const editBook = (book)=>{
        //     bookId.value=book.id;
        //     form.title=book.title;
        //     form.author=book.author;
        //     form.genre=book.genre;
        //     form.description=book.description;
        //     form.isbn=book.isbn;
        //     form.published=book.published;
        //     form.publisher=book.publisher;
        //     form.imgshow=book.image;
        // }

        //onMounted(getBooks());

        // const formReset=()=>{
        //     bookId.value='';
        //     form.title='';
        //     form.author='';
        //     form.genre='';
        //     form.description='';
        //     form.isbn='';
        //     form.image='';
        //     form.published='';
        //     form.publisher='';
        //     form.imageReset=null
        // }

        return {
            books,
            form,
            errors,
            bookId       
        }
    },
    mounted() {
        this.getBooksFromMethod()
    },
    data(){
        return{
            search:''
        }
    },
    watch: {
        // whenever question changes, this function will run
        search(newSearch, oldSearch) {
            if (newSearch != oldSearch) {
                this.getBooksFromMethod()
            }
        }
    },
     methods: {

            uploadPhoto(e){
                
              let file = e.target.files[0];
                let reader = new FileReader();  
                
                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                     this.form.image = reader.result;
                    }              
                     reader.readAsDataURL(file);
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            getBooksFromMethod(page=1) {
                axios.get(`api/books?page=${page}&search=${this.search}`)
                .then(response => {
                    console.log(response.data)
                    this.books = response.data
                });
            },
            editBook(book) {
                 this.bookId.value=book.id;
                this.form.title=book.title;
                this.form.author=book.author;
                this.form.genre=book.genre;
                this.form.description=book.description;
                this.form.isbn=book.isbn;
                this.form.published=book.published;
                this.form.publisher=book.publisher;
                this.form.imgshow=book.image;
            },
            formReset(book) {
                this.bookId.value='';
                this.form.title='';
                this.form.author='';
                this.form.genre='';
                this.form.description='';
                this.form.isbn='';
                this.form.image='';
                this.form.published='';
                this.form.publisher='';
                this.form.imageReset=null
            },
            deleteBook(book) {
                 axios.post('api/destroy/books/'+book.id, this.form)
                .then((response) => {
                    this.getBooksFromMethod()
                    this.formReset()
                })
                .catch((err) => {
                    console.log("Checker",err)
                })
            },
            updateBook(book) {
                 axios.post('api/update/books/'+this.bookId.value, this.form)
                    .then((response) => {
                        this.getBooksFromMethod()
                        this.formReset()
                        $('#myModal').modal("hide")
                    })
                    .catch((err) => {
                        console.log("Checker",err)
                        var data=[]
                        for(const key in err.response.data.errors)
                        {
                            data.push(err.response.data.errors[key][0])
                        }  
                        this.errors.value = data
                    })
            },
            storeBook(book) {
                  axios.post('api/books', this.form)
                    .then((response) => {
                        this.getBooksFromMethod()
                        this.formReset()
                        $('#myModal').modal("hide")
                    })
                    .catch((err) => {
                        console.log("Checker",err)
                        var data=[]
                        for(const key in err.response.data.errors)
                        {
                            data.push(err.response.data.errors[key][0])
                        }  
                        this.errors.value = data
                    })
            }
            
     },
     components:{
        Bootstrap5Pagination 
    }
    
}
</script>