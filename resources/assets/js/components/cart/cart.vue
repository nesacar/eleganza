<template>
    <div>
        <div class="cart-section">
            <div class="cart-header">
                <div class="cart-header__label cart-header__label--artikal">artikal</div>
                <div class="cart-header__label cart-header__label--opis">opis</div>
                <div class="cart-header__label cart-header__label--kolicina">kolicina</div>
                <div class="cart-header__label cart-header__label--cena">cijena artikla</div>
                <div class="cart-header__label cart-header__label--total">sveukupnu</div>
            </div>
            <ul class="cart-list" v-if="products">
                <product :products="products" @editProduct="edit($event)"></product>
            </ul>
        </div>

        <div class="cart__promo cart-section">
            <h3>promo kod</h3>
            <div class="row">
                <div class="col-lg-6">
                    <p>Ukoliko imate promotivan kod za popust, molimo da ga ovdje unesete:</p></div>
                <div class="col-lg-6">
                    <div class="e-form__group">
                        <input type="text" name="code" class="nl-input nl-input--fat" placeholder="Unesite kod ovdje...">
                        <button class="e-btn e-btn--fat e-btn--primary" id="kupon" type="submit">potvrdi</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart__details cart-section">
            <h3>dostava</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="cart__dostava">
                        <h4>brza pošta</h4>
                        <div class="cart__radio-list">

                            <div class="cart__radio-list__item">
                                <div class="cart__radio-list__option">
                                    <div class="cart__radio-list__radio">

                                        <div class="e-radio">
                                            <input type="radio" class="e-radio__control" name="radios1" id="radio1">
                                            <div class="e-radio__background">
                                                <div class="e-radio__circle--outer"></div>
                                                <div class="e-radio__circle--inner"></div>
                                            </div>
                                        </div>
                                        <label for="radio1">UPS</label>

                                    </div>
                                    <div>Dostava paketa do 1.2.2019.</div>
                                </div>
                                <div class="cart__radio-list__value">besplatno</div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="cart__receipt">
                        <div class="cart__receipt__line">
                            <div>ukupno</div>
                            <div>hrk <span id="ukupno">100.00</span></div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>dostava</div>
                            <div>hrk <span id="dostava">0.00</span></div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>popust</div>
                            <div>hrk <span id="popust">0.00</span></div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>sveukupno</div>
                            <div class="big">hrk <span id="sveukupno">100.00</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { domain } from '../../domain.config';
    import product from './product.vue';

    export default {
        data(){
            return {
                products: {},
                sum: 0,
                omot: 16.41
            }
        },
        components: {
            'product': product
        },
        created(){
            this.getProducts();
        },
        methods: {
            getProducts(){
                axios.get('products')
                    .then(res => {
                        console.log(res.data.products);
                        this.products = res.data.products;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            sumProducts(){
                if(this.products.length > 0){
                    this.sum = 0;
                    for(pro in this.products){
                        this.sum = this.sum + pro.price_outlet * pro.count;
                        if(pro.checked){
                            this.sum = this.sum + this.omot * pro.count;
                        }
                    }
                }
                this.showSum();
            },
            edit(product){
                console.log(product.id);
                console.log('---');
                console.log(product.checked);
                console.log('---');
                console.log(product.count);
                this.sumProducts();
            },
            showSum(){
                console.log(this.sum);
            }
        }
    }
</script>