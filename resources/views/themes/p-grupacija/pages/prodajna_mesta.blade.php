@extends('themes.'.$theme->slug.'.index')

@section('title')
    Prodajna mesta | p-grupacija.hr
@endsection

@section('keywords'){{ $settings->keywords }}@endsection

@section('seo_social_stuff')
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ url('/') }}">
    <meta property="og:url" content="{{ url('info/prodajna-mesta') }}">
    <meta property="og:image" content="{{ url('img/logo.png') }}">
@endsection

@section('content')
    <div class="container ">
        <div class="prodajnaMestaCover" style="position:relative;">
            <div class="textholder" style="min-width: 350px;">
                <h2><a href="">prodajna <span>mjesta</span></a></h2>
            </div>
            <img src="{{ url($theme->slug.'/img/servis_cover.jpg') }}">
        </div>
    </div>

    <div class="container">
        <div class="col-md-3 prodajna">
            <h2 class="choose">IZABERITE BREND
                {!! HTML::image($theme->slug.'/img/servis_cover.jpg', 'prodajna mjesta', array('style' => 'position: absolute; right: 10px; top: 10px;')) !!}
            </h2>






            <ul class="prodajnaCro">
                <li id="tgheuer" class="active">
                    TAG HEUER
                </li>
                <li id="victorinox-div">
                    VICTORINOX SWISS ARMY
                </li>
                <li id="movado-div">
                    MOVADO
                </li>
                <li id="gaga-milano-div">
                    GAGÀ MILANO
                </li>
                <li id="luminox-div">
                    LUMINOX
                </li>
                <li id="nixon-div">
                    NIXON
                </li>
                <li id="sevenFriday">
                    SEVENFRIDAY
                </li>
                <li id="mondain-div">
                    MONDAIN
                </li>
                <li id="perelet-div">
                    PERRELET
                </li>
                <li id="caran-div">
                    CARAN D'ACHE
                </li>
                <li id="bogner">
                    BOGNER
                </li>
                <li id="victorinox-travel">
                    VICTORINOX TRAVEL GEAR
                </li>
                <li id="staub">
                    STAUB
                </li>
                <li id="zwilling">
                    ZWILLING
                </li>
                <li id="epicurean">
                    EPICUREAN
                </li>
            </ul>
        </div>

        <div class="col-md-9 prodajna" style="padding-top: 30px;">
            <div class="tgheuer">
                <div class="prodajnoMesto">
                    <h2>Dicta Exclusive</h2>
                    <p>Tower Centar, Pećine</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/403-796</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Dicta Arena centar</h2>
                    <p>Lanište 32</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/6524-231</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Dicta RI</h2>
                    <p>Robna Kuća Rijeka</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/311-007</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Mamić</h2>
                    <p>vl. Pero Mamić</p>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Anda Store</h2>
                    <p>Mall of Split</p>
                    <p>ul. Josipa Jovića 63, Split</p>
                    <p>telefon: 021/817-068</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Marli</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-583</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Watch & Jewellery shop David</h2>
                    <p>Giardini 7</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/215-872</p>
                    <p>mobitel: 091/1545-454</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/231 499</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Pred Dvorom 2</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/324-764</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>B-Vama</h2>
                    <p>Obala hrv. narodnog preporoda 2</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/347-222</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>B-Vama – Joker centar</h2>
                    <p>Put brodarice 6</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/396-818</p>


                </div>
                <div class="clear"></div>
                <div class="prodajnoMesto">
                    <h2>Exclusive centar Božo Paić</h2>
                    <p>Stjepana Radića 4</p>
                    <p>22000 Šibenik</p>
                    <p>telefon: 022/214-254</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Zagreb</h2>
                    <p>Duty Free Shop</p>
                    <p>Pleso bb, Zagreb</p>
                    <p>telefon: 01/4562-504</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Trg sv. Stjepana 14</p>
                    <p>21450 Hvar</p>



                </div>



            </div> <!-- tagheuer -->

            <div class="victorinox-div">
                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Silver Time - City Colosseum</h2>
                    <p>Josipa Rimca 7</p>
                    <p>35000 Slavonski brod</p>
                    <p>telefon: 035/250-568</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>B-Vama – Joker centar</h2>
                    <p>Put brodarice 6</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/396-818</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/ 231 499</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Trg sv. Stjepana 14</p>
                    <p>21450 Hvar</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Ilica 168</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/3703 566</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Watch & Jewellery shop David</h2>
                    <p>Giardini 7</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/215-872</p>
                    <p>mobitel: 091/1545-454</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>BLISS</h2>
                    <p>Matošićeva 21</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/642-851</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Mamić</h2>
                    <p>vl. Pero Mamić</p>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Urar Butuči</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-659</p>


                </div>

            </div> <!-- victorinox-div -->

            <div class="movado-div">
                <div class="prodajnoMesto">
                    <h2>Mamić</h2>
                    <p>vl. Pero Mamić</p>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Mamić</h2>
                    <p>vl. Pero Mamić</p>
                    <p>Vlaška 57</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4616-367</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>BLISS</h2>
                    <p>Matošićeva 21</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/642-851</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Pred Dvorom 2</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/324-764</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Urar Butuči</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-659</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Ilica 168</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/3703 566</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/ 231 499</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>


                </div>

            </div> <!-- movado-div -->

            <div class="gaga-milano-div">
                <div class="prodajnoMesto">
                    <h2>Marli</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-583</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Pred Dvorom 2</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/324-764</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>B-Vama</h2>
                    <p>Obala hrv. narodnog preporoda 2</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/347-222</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Watch & Jewellery shop David</h2>
                    <p>Giardini 7</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/215-872</p>
                    <p>mobitel: 091/1545-454</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Ilica 168</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/3703 566</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/ 231 499</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>BLISS</h2>
                    <p>Matošićeva 21</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/642-851</p>
                </div>

            </div> <!-- gaga-milano-div -->
            <div class="luminox-div">
                <div class="prodajnoMesto">
                    <h2>Urar Mamić</h2>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Urar Butuči</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-659</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Pred Dvorom 2</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/324-764</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>


                </div>

                <div class="prodajnoMesto">
                    <h2>Urarstvo Samardžić</h2>
                    <p>Tratinska 18</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: +385 01 3822 011</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Watch & Jewellery shop David</h2>
                    <p>Giardini 7</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/215-872</p>
                    <p>mobitel: 091/1545-454</p>

                </div>

            </div> <!-- luminox-div -->
            <div class="nixon-div">

                <div class="prodajnoMesto">
                    <h2>Urar Mamić</h2>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Placa 12</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/321-314</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>BLISS</h2>
                    <p>Matošićeva 21</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/642-851</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Pred Dvorom 2</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/324-764</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Oakley shop</h2>
                    <p>Adamićeva 17</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/211-541</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Silver Time – City Colosseum</h2>
                    <p>Josipa Rimca 7</p>
                    <p>35000 Slavonski brod</p>
                    <p>telefon: 035/250-568</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Trg sv. Stjepana 14</p>
                    <p>21450 Hvar</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Hunto</h2>
                    <p>Shopping Center „JOKER“</p>
                    <p>Put brodarice 6</p>
                    <p>21000 Split</p>
                    <p>telefon:021/339 069</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Chill Shop</h2>
                    <p>Preradovićeva 22</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/5584 577</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Ilica 168</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/3703 566</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Anda Store</h2>
                    <p>SUB City centar</p>
                    <p>Šetalište dr. Franje Tuđmana 2a</p>
                    <p>20000 Dubrovnik</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Urar Butuči</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-659</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Experience bike & ski shop</h2>
                    <p>Kastavska cesta 23</p>
                    <p>51211 Matulji</p>
                    <p>telefon: 051/277-094</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Market</h2>
                    <p>Frana Petrića 3</p>
                    <p>10000 Zagreb</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Watch & Jewellery shop David</h2>
                    <p>Giardini 7</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/215-872</p>
                    <p>mobitel: 091/1545-454</p>

                </div>

            </div> <!-- nixon-div -->
            <div class="sevenFriday">
                <div class="prodajnoMesto">
                    <h2>Marli</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-583</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Urar Mamić</h2>
                    <p>Vlaška 57</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4616-367</p>

                </div>
            </div> <!-- sevenFriday -->
            <div class="mondain-div">
                <div class="prodajnoMesto">
                    <h2>Urar Mamić</h2>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Placa 12</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon:  020/321-314</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Urar Mamić</h2>
                    <p>Vlaška 57</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4616-367</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Watch & Jewellery shop David</h2>
                    <p>Giardini 7</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/215-872</p>
                    <p>mobitel: 091/1545-454</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Silver Time – City Colosseum</h2>
                    <p>Josipa Rimca 7</p>
                    <p>35000 Slavonski brod</p>
                    <p>telefon: 035/250-568</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>B-Vama – Joker centar</h2>
                    <p>Put brodarice 6</p>
                    <p>21000 Split</p>
                    <p>telefon: 021/396-818</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Glasnović Zlatarstvo</h2>
                    <p>Ilica 168</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/3703 566</p>

                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/ 231 499</p>


                </div>

            </div> <!-- mondain-div -->

            <div class="perelet-div">
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>
                </div>
            </div> <!-- perelet-div -->

            <div class="caran-div">
                <div class="prodajnoMesto">
                    <h2>Satovi Novak</h2>
                    <p>Decumanus 28</p>
                    <p>52440 Poreč</p>
                    <p>telefon: 052/435-683</p>

                </div>
                <div class="prodajnoMesto">
                    <h2>Urar Mamić</h2>
                    <p>Gajeva 4</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4870-700</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Urar Butuči</h2>
                    <p>Vlaška 13</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4816-659</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>
                </div>

            </div> <!-- caran-div -->

            <div class="bogner">
                <div class="prodajnoMesto">
                    <h2>Zdravlje i ljepota</h2>
                    <p>Korzo 29</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/330-006</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Mondiš</h2>
                    <p>Pod zidom 3</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4812-696</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Parfumerija Fendi</h2>
                    <p>Anticova 11</p>
                    <p>52100 Pula</p>
                    <p>telefon: 052/212-311</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Borza grupa</h2>
                    <p>Pred dvorom 2</p>
                    <p>20000 Dubrovnik</p>
                    <p>telefon: 020/323-570</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna Luka Zadar</h2>
                    <p>Duty Free Shop</p>
                    <p>23 222 Zemunik</p>
                    <p>telefon: 023/205-800</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Split</h2>
                    <p>Duty Free Shop</p>
                    <p>21216 Kaštel Štafilić</p>
                    <p>telefon: 021/203-426</p>
                </div>


            </div>  <!-- bogner -->

            <div class="victorinox-travel">
                <div class="prodajnoMesto">
                    <h2>Zdravlje i ljepota</h2>
                    <p>Korzo 29</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/330-006</p>
                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Rijeka</h2>
                    <p>Duty Free Shop</p>
                    <p>51513 Omišalj</p>
                    <p>telefon: 051/842-040</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Pula</h2>
                    <p>Duty Free Shop</p>
                    <p>52210 Ližnjan</p>
                    <p>telefon: 052/530-105</p>


                </div>
                <div class="prodajnoMesto">
                    <h2>Zračna luka Dubrovnik</h2>
                    <p>Duty Free Shop</p>
                    <p>20213 Čilipi</p>
                    <p>telefon: 020/773-100</p>
                </div>

            </div> <!-- victorinox-travel -->

            <div class="staub">
                <div class="prodajnoMesto">
                    <h2>Sol i papar</h2>
                    <p>Vlaška ulica 78</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4610 355</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Oko stola</h2>
                    <p>Varšavska ulica 4</p>
                    <p>10000 Zagreb</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/231 499</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Scavolini Store Rijeka</h2>
                    <p>Prolaz Marije K. Kozulić</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/275-600</p>
                </div>

            </div> <!-- staub -->

            <div class="zwilling">
                <div class="prodajnoMesto">
                    <h2>Sol i papar</h2>
                    <p>Vlaška ulica 78</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4610 355</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Oko stola</h2>
                    <p>Varšavska ulica 4</p>
                    <p>10000 Zagreb</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/231 499</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Scavolini Store Rijeka</h2>
                    <p>Prolaz Marije K. Kozulić</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/275-600</p>
                </div>
            </div> <!-- zwilling -->

            <div class="epicurean">
                <div class="prodajnoMesto">
                    <h2>Sol i papar</h2>
                    <p>Vlaška ulica 78</p>
                    <p>10000 Zagreb</p>
                    <p>telefon: 01/4610 355</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Oko stola</h2>
                    <p>Varšavska ulica 4</p>
                    <p>10000 Zagreb</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>ZTO Futura</h2>
                    <p>Riva lošinjskih kapetana 7</p>
                    <p>51550 Lošinj</p>
                    <p>telefon: 051/231 499</p>
                </div>

                <div class="prodajnoMesto">
                    <h2>Scavolini Store Rijeka</h2>
                    <p>Prolaz Marije K. Kozulić</p>
                    <p>51000 Rijeka</p>
                    <p>telefon: 051/275-600</p>
                </div>
            </div> <!-- epicurean -->

        </div>

    </div>
@endsection

@section('footer_scripts')

    padajuca(www);
    $(window).resize(function(){
        var w = $(window).width();
        padajuca(w);
    });

    function padajuca(www){
        if(www > 768){
            $('#tag1').css({'display':'block'});
            $('#luminox1').css({'display':'block'});
            $('#victorinox1').css({'display':'block'});
            $('#movado1').css({'display':'block'});
        }else{
            $('#tag1').css({'display':'none'});
            $('#luminox1').css({'display':'none'});
            $('#victorinox1').css({'display':'none'});
            $('#movado1').css({'display':'none'});
        }
    }


    $('#tag').click(function (e) {
        e.stopPropagation();
        $('#tag1').slideToggle();
    });

    $('#luminox').click(function (e) {
        e.stopPropagation();
        $('#luminox1').slideToggle();
    });

    $('#victorinox').click(function (e) {
        e.stopPropagation();
        $('#victorinox1').slideToggle();
    });
    $('#movado').click(function (e) {
        e.stopPropagation();
        $('#movado1').slideToggle();
    });

    function centriraj(){
        var w = $('.prodajnaMestaCover').width();
        var h = $('.prodajnaMestaCover').height();

        var w2 = $('.textholder').width();
        var h2 = $('.textholder').height();

        $('.textholder').css({'top': (h - h2)/2, 'left': (w - w2)/2, 'margin-left': 0});
    }
    centriraj();
    setTimeout(function(){
        centriraj();
    }, 1500);

    $(window).resize(function(){
        centriraj();
    });

@endsection