<template>
    <div style="min-width: 50px">
        <img :src="image" class="thumb" v-if="showImage">

        <label class="labela" v-if="!showImage">
            <input type="file" @change="setUpFileUploader" v-if="!showImage">
        </label>
    </div>
</template>

<script>
    export default {
        props: ['product_id'],
        data(){
            return {
                image: '',
                showImage: false
            }
        },
        mounted() {

        },
        methods:{
            setUpFileUploader(e){
                this.loader = true;
                let reader = new FileReader();
                let files = e.target.files;
                if(!files.length){
                    return
                }
                reader.readAsDataURL(files[0]);
                reader.onload = (e) => {

                    this.image = e.target.result;
                    this.showImage = true;
                    this.$emit('imageAdded', this.image);
                }

            }
        }
    }
</script>

<style scoped>
    input[type="file"]{
        display: none;
    }
    .labela{
        margin-left: auto;
        margin-right: auto;
    }
</style>