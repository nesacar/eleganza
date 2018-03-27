<template>
    <li class="cart-list__item row">
        <div class="col-lg-8 col-md-6 cart-list__item__cell">
            <div class=cart-list__item__img>
                <div class="e-thumbnail e-image e-image--11">
                    <a href="#"><img :src="domain + product.image" alt="slika"></a>
                </div>
            </div>
            <div class=cart-list__item__about>
                <div class=cart-list__item__brand v-if="product.brand">{{ product.brand.title }}</div>
                <div class=cart-list__item__model>{{ product.title }}</div>
                <hr>
                <div class=e-form__cb-group>
                    <div class=e-checkbox>
                        <input id=gift type=checkbox class="e-checkbox__control gift" @click="clickOmot(product)">
                        <div class=e-checkbox__background>
                            <svg class=e-checkbox__checkmark viewBox="0 0 24 24"> <path class=e-checkbox__path fill=none stroke=white d="M1.73,12.91 8.1,19.28 22.79,4.59"></path> </svg>
                        </div>
                    </div>
                    <label for=gift>Umotaj ovaj artikal kao poklon (+ hrk <span class="js-omot">{{ omot }}</span>)</label>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 cart-list__item__cell">
            <div class=cart-list__item__count>
                <input class="nl-input count" type=number name=counts[] min="1" max="10" v-model="product.count" @change="editCount(product)"> <span class="remove" style="cursor:pointer;" @click="remove()">X</span>
            </div>
            <div class="cart-list__item__digit cart-list__item__price"> hrk <span class="js-price">{{ price }}</span> </div>
            <div class="cart-list__item__digit cart-list__item__total"> hrk <span class="js-total">{{ total }}</span> </div>
        </div>
    </li>
</template>

<script>
    import { domain } from '../../domain.config';

    export default {
        data(){
          return {
              omot: 16.41,
              domain: domain,
              price: 0,
              total: 0
          }
        },
        props: ['product'],
        created(){
            this.price = this.product.price_outlet;
            this.total = this.product.price_outlet;
        },
        methods: {
            clickOmot(product){
                product.checked = !product.checked;
                //this.setPrice(product);
                this.setTotal(product);
                this.$emit('editProduct', product);
            },
            editCount(product){
                //this.setPrice(product);
                this.setTotal(product);
                this.$emit('editProduct', product);
            },
            remove(){
                this.$emit('remove', this.product);
            },
            setPrice(product){
                this.price = product.count * product.price_outlet;
            },
            setTotal(product){
                this.total = product.checked ? product.count * (product.price_outlet + this.omot) : product.count * product.price_outlet;
            }
        }
    }
</script>