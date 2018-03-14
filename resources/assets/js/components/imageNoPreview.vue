<template>
    <div style="min-width: 50px">
        <label>
            <input type="file" @change="setUpFileUploader">
        </label>
    </div>
</template>

<script>
    export default {
        props: ['product_id'],
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