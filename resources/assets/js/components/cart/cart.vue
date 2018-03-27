<template>
    <div>

        <div class="cart-section">
            <div class=cart-nav>
                <a :href="domain" class="e-btn e-btn--fat e-btn--invert">&lt; nastavi kupovinu</a>
                <a href=# class="e-btn e-btn--fat e-btn--primary submit" v-if="auth && products.length > 0" @click.prevent="submit()">sigurna uplata</a>
                <a :href="domain + 'logovanje'" class="e-btn e-btn--fat e-btn--primary" v-else>prijavi se</a>
            </div>
        </div>

        <div class="cart-section">
            <div class="cart-header">
                <div class="cart-header__label cart-header__label--artikal">artikal</div>
                <div class="cart-header__label cart-header__label--opis">opis</div>
                <div class="cart-header__label cart-header__label--kolicina">kolicina</div>
                <div class="cart-header__label cart-header__label--cena">cijena artikla</div>
                <div class="cart-header__label cart-header__label--total">sveukupnu</div>
            </div>
            <ul class="cart-list" v-if="products">
                <div v-for="product in products">
                    <product :product="product" @editProduct="editProduct($event)" @remove="remove($event)"></product>
                </div>
                <!--<product :products="products" @editProduct="editProduct($event)"></product>-->
            </ul>
        </div>

        <div class="cart__promo cart-section">
            <h3>promo kod</h3>
            <div class="row">
                <div class="col-lg-6">
                    <p>Ukoliko imate promotivan kod za popust, molimo da ga ovdje unesete:</p></div>
                <div class="col-lg-6">
                    <div class="e-form__group">
                        <input type="text" name="code" v-model="coupon" class="nl-input nl-input--fat" placeholder="Unesite kod ovdje...">
                        <button class="e-btn e-btn--fat e-btn--primary" id="kupon" @click.prevent="setCoupon()">potvrdi</button>
                    </div>
                    <div class="e-form__group">
                        <small class="form-text text-muted text-error" v-if="error != null">{{ error }}</small>
                        <small class="form-text text-muted text-success" v-if="success != null">{{ success }}</small>
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
                            <div>hrk <span id="ukupno">{{ total }}</span></div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>dostava</div>
                            <div>hrk <span id="dostava">0.00</span></div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>popust</div>
                            <div>hrk <span id="popust">{{ discount }}%</span></div>
                        </div>
                        <div class="cart__receipt__line">
                            <div>sveukupno</div>
                            <div class="big">hrk <span id="sveukupno">{{ sum }}</span></div>
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
                total: 0,
                omot: 16.41,
                coupon: null,
                error: null,
                success: null,
                discount: 0,
                domain: domain,
                omots: [],
            }
        },
        props: ['auth'],
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
                        this.products = res.data.products;
                        this.sumProducts();
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            sumProducts(){
                if(this.products.length > 0){
                    this.sum = 0;
                    this.total = 0;
                    for(let i=0;i<this.products.length;i++){
                        let price = this.sum + this.products[i].price_outlet * this.products[i].count;
                        this.sum = this.total = this.round(price, 2);
                        if(this.products[i].checked){
                            let price = this.sum + this.omot * this.products[i].count;
                            this.sum = this.total = this.round(price, 2);
                        }
                    }
                }
                this.setDiscount();
                this.showSum();
            },
            editProduct(product){
                this.sumProducts();
            },
            showSum(){
                console.log(this.sum);
            },
            round(value, decimals) {
                return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
            },
            setCoupon(){
                if(this.coupon != null && this.coupon != ''){
                    axios.post('api/set-coupon', {'coupon': this.coupon})
                        .then(res => {
                            this.discount = res.data.discount;
                            this.success = res.data.success;
                            this.error = null;
                            this.sumProducts();
                        })
                        .catch(e => {
                            this.error = e.response.data.error;
                            this.success = null;
                            this.sumProducts();
                        });
                }
            },
            setDiscount(){
                if(this.discount > 0){
                    let price = this.sum - (this.discount / 100) * this.sum;
                    this.sum = this.round(price, 2);
                }
            },
            remove(row){
                axios.post('remove-from-cart/' + row.id, {})
                    .then(res => {
                        console.log(res.data.success);
                        this.products = this.products.filter(function (item) {
                            return row.id != item.id;
                        });
                        this.sumProducts();
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            submit(){
                const newProducts = this.products.map(product => {
                    const { id, checked, ...rest } = product;
                    return {
                        id,
                        checked
                    };
                });

                console.log(newProducts);
                console.log(this.discount);
            }
        }
    }
</script>

<style scoped>
    .text-error{
        color: red;
    }
    .text-success{
        color: green;
    }
</style>