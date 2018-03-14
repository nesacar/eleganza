<template>
    <tr>
        <td><i class="fa fa-arrow-down" @click="copyProduct(product)" aria-hidden="true"></i> <i class="fa fa-remove" @click="removeProduct(product)" aria-hidden="true"></i> </td>
        <td><input type="text" v-model="product.code" class="form-control"></td>
        <td><input type="text" v-model="product.title" class="form-control"></td>
        <td><input type="text" v-model="product.short" class="form-control"></td>
        <td><input type="text" v-model="product.body" class="form-control"></td>
        <td><image-no-preview @imageAdded="getImage($event)"></image-no-preview></td>
        <td>
            <select name="language_id" v-model="product.language_id">
                <option v-for="locale in locales" :value="locale.id">{{ locale.title }}</option>
            </select>
        </td>
        <td>
            <select name="publish" v-model="product.publish">
                <option value="1">Da</option>
                <option value="0">Ne</option>
            </select>
        </td>
        <td><datetime v-model="product.publish_at" class="rasiri" :config="{format: 'YYYY-MM-DD H:s'}"></datetime></td>
        <td><input type="text" v-model="product.amount" class="form-control"></td>
        <td><input type="text" v-model="product.price_small" class="form-control"></td>
        <td><input type="text" v-model="product.discount" class="form-control"></td>
        <td><input type="text" v-model="product.price_outlet" class="form-control"></td>
        <td>
            <select name="brand_id" v-model="product.brand_id">
                <option v-for="(brand, index) in brands" :value="brand.id" :selected="index === 0">{{ brand.title }}</option>
            </select>
        </td>
        <td>
            <select name="set_id" v-model="product.set_id" @change="getProperties()">
                <option v-for="(set, index) in sets" :value="set.id" :selected="index === 0">{{ set.title }}</option>
            </select>
        </td>
        <td>
            <select name="cat1_id" v-model="product.cat1_id" @change="getCats2(product.cat1_id)">
                <option v-for="(cat, index) in product.cats1" :value="cat.id" :selected="index === 0">{{ cat.title }}</option>
            </select>
        </td>
        <td>
            <select name="cat2_id" v-model="product.cat2_id" @change="getCats3(product.cat2_id)">
                <option v-for="(cat, index) in product.cats2" :value="cat.id" :selected="index === 0">{{ cat.title }}</option>
            </select>
        </td>
        <td>
            <select name="cat3_id" v-model="product.cat3_id" @change="getCats4(product.cat3_id)">
                <option v-for="(cat, index) in product.cats3" :value="cat.id" :selected="index === 0">{{ cat.title }}</option>
            </select>
        </td>
        <td>
            <select name="cat4_id" v-model="product.cat4_id">
                <option v-for="(cat, index) in product.cats4" :value="cat.id" :selected="index === 0">{{ cat.title }}</option>
            </select>
        </td>
        <td>
            <select name="property1_id" v-model="product.property1_id" @change="getAttribute(product.property1_id, 1)">
                <option v-for="(property, index) in product.prop1" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att1_id" v-model="product.att1_id">
                <option v-for="(attribute, index) in product.attEl1" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property2_id" v-model="product.property2_id" @change="getAttribute(product.property2_id, 2)">
                <option v-for="(property, index) in product.prop2" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att2_id" v-model="product.att2_id">
                <option v-for="(attribute, index) in product.attEl2" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property3_id" v-model="product.property3_id" @change="getAttribute(product.property3_id, 3)">
                <option v-for="(property, index) in product.prop3" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att3_id" v-model="product.att3_id">
                <option v-for="(attribute, index) in product.attEl3" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property4_id" v-model="product.property4_id" @change="getAttribute(product.property4_id, 4)">
                <option v-for="(property, index) in product.prop4" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att4_id" v-model="product.att4_id">
                <option v-for="(attribute, index) in product.attEl4" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property5_id" v-model="product.property5_id" @change="getAttribute(product.property5_id, 5)">
                <option v-for="(property, index) in product.prop5" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att5_id" v-model="product.att5_id">
                <option v-for="(attribute, index) in product.attEl5" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property6_id" v-model="product.property6_id" @change="getAttribute(product.property6_id, 6)">
                <option v-for="(property, index) in product.prop6" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att6_id" v-model="product.att6_id">
                <option v-for="(attribute, index) in product.attEl6" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property7_id" v-model="product.property7_id" @change="getAttribute(product.property7_id, 7)">
                <option v-for="(property, index) in product.prop7" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att7_id" v-model="product.att7_id">
                <option v-for="(attribute, index) in product.attEl7" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
        <td>
            <select name="property8_id" v-model="product.property8_id" @change="getAttribute(product.property8_id, 8)">
                <option v-for="(property, index) in product.prop8" :value="property.id" :selected="index === 0">{{ property.title }} / {{ property.set_title }}</option>
                <option value="0">Nema osobine</option>
            </select>
        </td>
        <td>
            <select name="att8_id" v-model="product.att8_id">
                <option v-for="(attribute, index) in product.attEl8" :value="attribute.id" :selected="index === 0">{{ attribute.title }}</option>
            </select>
        </td>
    </tr>
</template>

<script>
    import imageNoPreview from './imageNoPreview.vue';
    import datetime from 'vue-bootstrap-datetimepicker';
    import { domain } from '../domain.config';
    import swal from 'sweetalert2';

    export default{
        props: ['product'],
        data(){
            return{
                locales: [],
                brands: [],
                sets: [],
            }
        },
        components: {
            'image-no-preview': imageNoPreview,
            'datetime': datetime
        },
        created(){
            this.getBrands();
            this.getLocales();
            this.getSets();
            this.getCats1();
            this.getProperties();
        },
        methods: {
            copyProduct(product){
                this.$emit('copyProduct', product);
            },
            removeProduct(product){
                this.$emit('removeProduct', product);
            },
            getBrands(){
                if(this.brands.length == 0){
                    axios.post(domain + 'api/brands')
                        .then((res) => {
                            this.brands = res.data.brands;
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }
            },
            getLocales(){
                if(this.locales.length == 0){
                    axios.post(domain + 'api/locales')
                        .then((res) => {
                            this.locales = res.data.locales;
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }
            },
            getSets(){
                if(this.sets.length == 0){
                    axios.post(domain + 'api/sets')
                        .then((res) => {
                            this.sets = res.data.sets;
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }
            },
            getCats1(){
                if(this.product.cats1.length == 0){
                    axios.post(domain + 'api/categories', {'category_id': 0, 'level': 1})
                        .then((res) => {
                            this.product.cats1 = res.data.categories;
                            this.product.cats2 = [];
                            this.product.cat2_id = null;
                            this.product.cats3 = [];
                            this.product.cat3_id = null;
                            this.product.cats4 = [];
                            this.product.cat4_id = null;
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }
            },
            getCats2(cat_id){
                axios.post(domain + 'api/categories', {'category_id': cat_id, 'level': 2})
                    .then((res) => {
                        this.product.cats2 = res.data.categories;
                        this.product.cats3 = [];
                        this.product.cat3_id = null;
                        this.product.cats4 = [];
                        this.product.cat4_id = null;
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
            getCats3(cat_id){
                axios.post(domain + 'api/categories', {'category_id': cat_id, 'level': 3})
                    .then((res) => {
                        this.product.cats3 = res.data.categories;
                        this.product.cats4 = [];
                        this.product.cat4_id = null;
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
            getCats4(cat_id){
                axios.post(domain + 'api/categories', {'category_id': cat_id, 'level': 4})
                    .then((res) => {
                        this.product.cats4 = res.data.categories;
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
            getProperties(){
                if(this.product.set_id == null){
                    axios.post(domain + 'api/properties', {'set_id': 0})
                        .then((res) => {
                            this.product.prop1 = res.data.properties;
                            this.product.prop2 = res.data.properties;
                            this.product.prop3 = res.data.properties;
                            this.product.prop4 = res.data.properties;
                            this.product.prop5 = res.data.properties;
                            this.product.prop6 = res.data.properties;
                            this.product.prop7 = res.data.properties;
                            this.product.prop8 = res.data.properties;
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }else{
                    axios.post(domain + 'api/properties', {'set_id': this.product.set_id})
                        .then((res) => {
                            this.product.prop1 = res.data.properties;
                            this.product.prop2 = res.data.properties;
                            this.product.prop3 = res.data.properties;
                            this.product.prop4 = res.data.properties;
                            this.product.prop5 = res.data.properties;
                            this.product.prop6 = res.data.properties;
                            this.product.prop7 = res.data.properties;
                            this.product.prop8 = res.data.properties;
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }
            },
            getAttribute(property_id, index){
                axios.post(domain + 'api/attributes', {'property_id': property_id})
                    .then((res) => {
                        console.log(property_id);
                        switch(index) {
                            case 1:
                                this.product.attEl1 = res.data.attributes;
                                if(property_id == 0) this.product.att1_id = null;
                                break;
                            case 2:
                                this.product.attEl2 = res.data.attributes;
                                if(property_id == 0) this.product.att2_id = null;
                                break;
                            case 3:
                                this.product.attEl3 = res.data.attributes;
                                if(property_id == 0) this.product.att3_id = null;
                                break;
                            case 4:
                                this.product.attEl4 = res.data.attributes;
                                if(property_id == 0) this.product.att4_id = null;
                                break;
                            case 5:
                                this.product.attEl5 = res.data.attributes;
                                if(property_id == 0) this.product.att5_id = null;
                                break;
                            case 6:
                                this.product.attEl6 = res.data.attributes;
                                if(property_id == 0) this.product.att6_id = null;
                                break;
                            case 7:
                                this.product.attEl7 = res.data.attributes;
                                if(property_id == 0) this.product.att7_id = null;
                                break;
                            case 8:
                                this.product.attEl8 = res.data.attributes;
                                if(property_id == 0) this.product.att8_id = null;
                                break;
                            default:
                                this.product.attEl1 = res.data.attributes;
                                if(property_id == 0) this.product.att1_id = null;
                        }
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
            getImage(image){
                this.product.image = image;
                swal({
                    position: 'center',
                    type: 'success',
                    title: 'Uspeh',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    }
</script>

<style scoped>
    @keyframes animateBackground {
        0%   {background-color: transparent;}
        80%  {background-color: #90EE90;}
        100% {background-color: transparent;}
    }

    .excel-tabela tr td{
        animation: animateBackground 1s ease;
    }

    .rasiri{
        width: 200px;
    }
    .fa-remove{
        cursor: pointer;
    }
</style>