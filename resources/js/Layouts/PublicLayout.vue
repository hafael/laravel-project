<template>
    <!-- header 
    ================================================== -->
    <header id="header" class="row">   

        <div class="header-logo">
            <a :href="route('welcome')">Autum Wallet</a>
        </div>

        <nav id="header-nav-wrap">
            <ul class="header-main-nav">
                <!-- <li class="current"><a class="smoothscroll"  href="#home" title="home">Home</a></li> -->
                <li><a class="smoothscroll"  href="#sobre" title="Sobre">Sobre</a></li>
                <li><a class="smoothscroll"  href="#blockchain" title="Blockchain">Blockchain</a></li>
                <li><a class="smoothscroll"  href="#tarifas" title="Tarifas">Tarifas</a></li>
                <!-- <li><a class="smoothscroll"  href="#depoimentos" title="Depoimentos">Casos de Uso</a></li> -->
                <li><a class="smoothscroll"  href="#stablecoins" title="Stablecoins">Stablecoins</a></li>	
            </ul>

            <a :href="route('login')" title="sign-up" class="button button-primary cta">
                {{ $page.props.user ? $page.props.user.name : 'Entrar' }}
            </a>
        </nav>

        <a class="header-menu-toggle" href="#"><span>Menu</span></a>
        
    </header> <!-- /header -->

    <!-- Page Content -->
    <main>
        <slot></slot>
    </main>

    <!-- footer
    ================================================== -->
    <footer>
        <div class="footer-main">
            <div class="row">  

                <div class="col-three md-1-3 tab-full footer-info">            

                    <div class="footer-logo"></div>

                    <p>
                        Autum Wallet conecta os serviços bancários ao poder dos cripto-ativos através de soluções integradas.
                    </p>

                    <ul class="footer-social-list">
                        <li>
                            <a href="#"><i class="fa fa-facebook-square"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-behance"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                    </ul>
                    
                    
                </div> <!-- end footer-info -->

                <div class="col-three md-1-3 tab-1-2 mob-full footer-contact">

                    <h4>Contato</h4>

                    <p>
                    Rua México, 31<br>
                    Centro do Rio, RJ <br>
                    24900-000 BR<br>
                    </p>

                    <p>
                    contato@autum.com.br <br>
                    Telefone: (+21) 971 965 544 <br>
                    Atendimento de segunda a sexta-feira, de 9 ás 16h.
                    </p>

                </div> <!-- end footer-contact -->  

                <div class="col-two md-1-3 tab-1-2 mob-full footer-site-links">

                    <h4>Mapa do Site</h4>

                    <ul class="list-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#sobre">Sobre Autum Wallet</a></li>
                        <li><a href="#tarifas">Blockchain</a></li>
                        <li><a href="#tarifas">Tarifas</a></li>
                        <li><a href="#stablecoin">Stablecoins</a></li>
                        <!-- <li><a href="#">FAQ</a></li> -->
                        <li><a href="/images/termos-de-uso-autum-wallet.pdf" target="_blank">Termos de uso</a></li>
                        <li><a href="/images/politica-de-privacidade-autum-wallet.pdf" target="_blank">Política de Privacidade</a></li>
                    </ul>	      		
                            
                </div> <!-- end footer-site-links --> 

                <div class="col-four md-1-2 tab-full footer-subscribe">

                    <h4>Notícias e novidades</h4>

                    <p>Cadastre-se para receber notícias e novidades em primeira mão sobre os nossos serviços. Fique atento à novos recursos e mudanças nas políticas de uso.</p>

                    <div class="subscribe-form">
                
                        <form id="mc-form" class="group" novalidate="true">

                            <input type="email" value="" name="EMAIL" class="email" id="mc-email" placeholder="Seu melhor email" required=""> 
                
                            <input type="submit" name="subscribe" value="Inscrever">
                
                            <label for="mc-email" class="subscribe-message"></label>
                
                        </form>

                    </div>	      		
                            
                </div> <!-- end footer-subscribe -->         

            </div> <!-- /row -->
        </div> <!-- end footer-main -->

        <div class="footer-bottom">

            <div class="row">

                <div class="col-twelve">
                    <div class="copyright">
                        <span>© Copyright Autum 2021.</span> 
                        <span>Autum Wallet é um serviço <a href="https://www.autum.com.br/" target="_blank">Autum</a></span>		         	
                    </div>

                    <div id="go-top">
                        <a class="smoothscroll" title="Ir ao topo" href="#top"><i class="icon-arrow-up"></i></a>
                    </div>
                </div>

            </div> <!-- end footer-bottom --> 

        </div>
    </footer>

    <cookie-law theme="dark-blue" storage-type="cookies" />

    <div id="preloader"> 
        <div id="loader"></div>
    </div>
</template>

<script>

    import CookieLaw from '@/Components/Cookie'
    
    export default {
        components: {
            CookieLaw
        },

        data() {
            return {
                
            }
        },

        computed: {
            
        },

        methods: {
            
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
