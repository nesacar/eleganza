<template>
    <div class="rasiri-ga">
        <table class="table table-hover excel-tabela">
            <thead>
            <tr>
                <th>#</th>
                <th>Šifra artikla</th>
                <th>Naziv artikla</th>
                <th>Kratak opis</th>
                <th>Ceo opis</th>
                <th>Slika</th>
                <th>Jezik</th>
                <th>Vidljivo</th>
                <th>Vidljivo od datuma</th>
                <th>Količina</th>
                <th>Cena</th>
                <th>Popust</th>
                <th>Outlet cena</th>
                <th>Brend</th>
                <th>Set</th>
                <th>Kat. 1</th>
                <th>Kat. 2</th>
                <th>Kat. 3</th>
                <th>Kat. 4</th>
                <th>Osobina 1</th>
                <th>Atribut 1</th>
                <th>Osobina 2</th>
                <th>Atribut 2</th>
                <th>Osobina 3</th>
                <th>Atribut 3</th>
                <th>Osobina 4</th>
                <th>Atribut 4</th>
                <th>Osobina 5</th>
                <th>Atribut 5</th>
                <th>Osobina 6</th>
                <th>Atribut 6</th>
                <th>Osobina 7</th>
                <th>Atribut 7</th>
                <th>Osobina 8</th>
                <th>Atribut 8</th>
            </tr>
            </thead>
            <tbody>
                <app-product v-for="product in products" :product="product" @copyProduct="copy($event)" @removeProduct="remove($event)" :key="product.id"></app-product>
            </tbody>
        </table>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="submit" class="btn btn-success" value="Dodaj" @click="save()">
            </div>
        </div>
    </div>
</template>

<script>
    import product from './product.vue';
    import swal from 'sweetalert2';
    import { domain } from '../domain.config';
    import moment from 'moment';

    export default{
        data(){
            return{
                products: []
            }
        },
        components: {
          'app-product': product
        },
        created(){
            this.setDefault();
        },
        methods: {
            save(){
                console.log(this.products);
                axios.post(domain + 'api/save-products', {'products': this.products})
                    .then((res) => {
                        if(res.status == 200){
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Izmene su sačuvane',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.setDefault();
                        }
                    })
                    .catch((e) => {
                        swal(
                            'Oops...',
                            'Došlo je do greške'
                        );
                        console.log(e);
                    });
            },
            copy(product){
                console.log(product);
                let newProduct = {
                    id: this.randomNumber(),
                    code: product.code,
                    title: product.title,
                    short: product.short,
                    body: product.body,
                    image: null,
                    language_id: product.language_id,
                    publish: product.publish,
                    publish_at: product.publish_at,
                    amount: product.amount,
                    price_small: product.price_small,
                    discount: product.discount,
                    price_outlet: product.price_outlet,
                    brand_id: product.brand_id,
                    set_id: product.set_id,
                    cats1: product.cats1,
                    cat1_id: product.cat1_id,
                    cats2: product.cats2,
                    cat2_id: product.cat2_id,
                    cats3: product.cats3,
                    cat3_id: product.cat3_id,
                    cats4: product.cats4,
                    cat4_id: product.cat4_id,
                    atts_id: product.atts_id,
                    att1_id: product.att1_id,
                    att2_id: product.att2_id,
                    att3_id: product.att3_id,
                    att4_id: product.att4_id,
                    att5_id: product.att5_id,
                    att6_id: product.att6_id,
                    att7_id: product.att7_id,
                    att8_id: product.att8_id,
                    prop1_id: product.prop1_id,
                    prop2_id: product.prop2_id,
                    prop3_id: product.prop3_id,
                    prop4_id: product.prop4_id,
                    prop5_id: product.prop5_id,
                    prop6_id: product.prop6_id,
                    prop7_id: product.prop7_id,
                    prop8_id: product.prop8_id,
                    prop1: product.prop1,
                    prop2: product.prop2,
                    prop3: product.prop3,
                    prop4: product.prop4,
                    prop5: product.prop5,
                    prop6: product.prop6,
                    prop7: product.prop7,
                    prop8: product.prop8,
                    attEl1: product.attEl1,
                    attEl2: product.attEl2,
                    attEl3: product.attEl3,
                    attEl4: product.attEl4,
                    attEl5: product.attEl5,
                    attEl6: product.attEl6,
                    attEl7: product.attEl7,
                    attEl8: product.attEl8,
                    brands: product.brands,
                    locales: product.locales,
                    publishes: [
                        {
                            title: 'da',
                            id: 1
                        },
                        {
                            title: 'ne',
                            id: 0
                        }
                    ],
                    sets: product.sets,
                };
                this.products.push(newProduct);
            },
            remove(product){
                this.products = this.products.filter(item => {
                   return item.id != product.id;
                });
            },
            randomNumber(){
                return Math.floor(Math.random() * 10000) + 1;
            },
            setDefault(){
                this.products = [
                    {
                        id: this.randomNumber(),
                        code: '',
                        title: '',
                        short: '',
                        body: '',
                        image: null,
                        language_id: 2,
                        publish: 1,
                        publish_at: moment().format('YYYY-MM-DD hh:mm:00'),
                        amount: 0,
                        price_small: 0,
                        discount: 0,
                        price_outlet: 0,
                        brand_id: null,
                        set_id: null,
                        cats1: [],
                        cat1_id: null,
                        cats2: [],
                        cat2_id: null,
                        cats3: [],
                        cat3_id: null,
                        cats4: [],
                        cat4_id: null,
                        att1_id: null, att2_id: null, att3_id: null, att4_id: null, att5_id: null, att6_id: null, att7_id: null, att8_id: null,
                        prop1_id: null, prop2_id: null, prop3_id: null, prop4_id: null, prop5_id: null, prop6_id: null, prop7_id: null, prop8_id: null,
                        prop1: {}, prop2: {}, prop3: {}, prop4: {}, prop5: {}, prop6: {}, prop7: {}, prop8: {},
                        attEl1: {}, attEl2: {}, attEl3: {}, attEl4: {}, attEl5: {}, attEl6: {}, attEl7: {}, attEl8: {},
                        brands: [],
                        locales: [],
                        publishes: [
                            {
                                title: 'da',
                                id: 1
                            },
                            {
                                title: 'ne',
                                id: 0
                            }
                        ],
                        sets: []
                    }
                ]
            }
        }
    }
</script>

<style scoped>
    .form-control{
        border-radius: 0;
        border: none;
    }
    .rasiri-ga{
        overflow-x: scroll;
        min-height: 65vh;
    }
</style>