<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">

            <h4 class="font-semibold text-lg text-gray-800">Obrigado por inscrever!</h4>
            <p class="text-gray-600 text-base mb-3">
                A Autum preza pela segurança e verificação dos dados dos usuários da nossa plataforma. Antes de começarmos, valide sua conta através do link que enviamos para e-mail fornecido durante o cadastro.
                Você receberá este e-mail em até 5 (cinco) minutos. Caso não encontre na sua caixa de entrada verifique sua caixa de SPAM.
            </p>
            <p class="text-gray-600 text-base mb-3">
                Caso não receba até o prazo estipulado, clique no link abaixo e solicite uma nova mensagem de confirmação.
            </p>
            
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
            Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o cadastro.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reenviar email de verificação
                </jet-button>

                <inertia-link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Sair</inertia-link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
