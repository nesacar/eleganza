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
                //this.loader = true;
                let reader = new FileReader();
                let files = e.target.files;
                if(!files.length){
                    return
                }
                reader.readAsDataURL(files[0]);
                reader.onload = (e) => {
                    this.image = e.target.result;
                    this.$emit('image', [this.image]);
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
