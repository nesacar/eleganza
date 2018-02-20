<template>
    <select class="form-control" @change="changeOption">
        <option v-for="(element, index) in elements" :value="element.id" :selected="index === 0">{{ element.title }}</option>
    </select>
</template>

<script>
    export default{
        data(){
          return{
              selected: {}
          }
        },
        props: ['elements'],
        methods:{
            changeOption(event){
                const options = event.target.options;
                const selectedOption = options[options.selectedIndex];
                this.$emit('vrednost', [selectedOption.value]);
            }
        }
    }
</script>

<style>

</style>