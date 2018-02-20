<template>
    <div>
        <p><i class="fa fa-plus" @click="addAttribute()" v-if="showPlus"></i></p>
        <p><i class="fa fa-remove" @click="removeAttribute()" v-if="showMinus"></i></p>
        <select class="form-control" @change="changeOption1" v-if="showProperty">
            <option v-for="(element, index) in elements" :value="element.id" :selected="index === 0">{{ element.title }} ( {{ element.set_title }} )</option>
        </select>
        <select class="form-control" @change="changeOption" v-if="showAttribute">
            <option v-for="(element, index) in attributes" :value="element.id" :selected="index === 0">{{ element.title }}</option>
        </select>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                elements: {},
                attributes: {},
                prop: null,
                showPlus: true,
                showMinus: false,
                showProperty: false,
                showAttribute: false,
            }
        },
        props: ['set_id', 'att_id', 'prop_id'],
        created(){
          if(this.att_id != null && this.prop_id != null){
            this.showPlus = false;
            this.showMinus = true;
            this.showProperty = true;
            this.showAttribute = false;
            console.log('do something');
          }else{
              console.log('why? att_id = ' + this.att_id + ' | prop_id = ' + this.prop_id);
          }
        },
        methods:{
            addAttribute(){
                axios.post('http://croatia.mia.rs/api/properties', {'set_id': this.set_id})
                    .then(response => {
                        this.elements = response.data.properties;
                        this.showProperty = true;
                        this.showPlus = false;
                        this.showMinus = true;

                        axios.post('http://croatia.mia.rs/api/attributes', {'property_id': this.elements[0].id})
                            .then(response => {
                                this.attributes = response.data.attributes;
                                this.showAttribute = true;
                                this.prop = this.elements[0].id;
                                this.$emit('vrednost', [this.attributes[0].id]);
                                this.$emit('vrednost2', [this.elements[0].id]);
                                this.$emit('vrednost3', [this.elements]);
                                this.$emit('vrednost4', [this.attributes]);
                            })
                            .catch(e => {
                                console.log(e);
                            });
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            removeAttribute(){
                this.elements = {};
                this.attributes = {};
                this.showProperty = false;
                this.showAttribute = false;
                this.showPlus = true;
                this.showMinus = false;
                this.$emit('vrednost', [null]);
                this.$emit('vrednost2', [null]);
                this.$emit('vrednost3', [null]);
                this.$emit('vrednost4', [null]);
            },
            changeOption1(event){
                const options = event.target.options;
                const selectedOption = options[options.selectedIndex];
                axios.post('http://croatia.mia.rs/api/attributes', {'property_id': selectedOption.value})
                    .then(response => {
                        this.attributes = response.data.attributes;
                        this.showProperty = false;
                        this.showAttribute = true;
                        this.$emit('vrednost', [this.attributes[0].id]);
                        this.$emit('vrednost2', [selectedOption.value]);
                        this.$emit('vrednost3', [this.prop]);
                        this.$emit('vrednost4', [this.attributes]);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            changeOption(event){
                const options = event.target.options;
                const selectedOption = options[options.selectedIndex];
                this.$emit('vrednost', [selectedOption.value]);
            }
        }
    }
</script>

<style scoped>
    div{
        min-width: 200px;
    }
</style>