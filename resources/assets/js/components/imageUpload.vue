<template>
    <div style="min-width: 50px">
        <img :src="image" class="thumb" v-if="showImage">

        <label class="labela" v-if="!showImage">
            <input type="file" @change="setUpFileUploader" v-if="!showImage">
        </label>
        <div class="loader" v-if="loader"></div>
        <i class="fa fa-spinner fa-spin" aria-hidden="true" v-if="loader"></i>
    </div>
</template>

<script>
    import { domain } from './../domain.config';

    export default {
        props: ['product_id'],
        data(){
            return {
                image: '',
                showImage: false,
                loader: false
            }
        },
        mounted() {
            
        },
        methods:{
            setUpFileUploader(e){
                this.loader = true;
                let data = new FormData();

                let file = e.target.files[0];
                let reader = new FileReader();
                let files = e.target.files;
                if(!files.length){
                    return
                }
                reader.readAsDataURL(files[0]);

                reader.onload = (e) => {
                    data.append('file', file);
                    axios.post('/admin/products/' + this.product_id + '/upload', data).then(response => {
                        this.showImage = true;
                        this.loader = false;
                        this.image = response.data.image;
                    });
                }

            }
        }
    }
</script>

<style scoped>
    input[type="file"]{
        display: none;
    }
</style>
