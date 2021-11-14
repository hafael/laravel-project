<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Senha" />
                <jet-input-password id="password" input-class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirme a senha" />
                <jet-input-password id="password_confirmation" input-class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                <span class="text-indigo-500 text-sm rounded-md bg-gray-100 my-2 p-2 block">
                    <ul class="list-disc pl-4">
                        <li :class="{'text-red-600': passwordNotEmpty && (!lengthIsValid || !isAlphaNumeric)}">A senha deve conter no mínimo <strong>6</strong> e no máximo <strong>12</strong> caracteres entre letras e números.</li>
                        <li :class="{'text-red-600': passwordNotEmpty && isLogicalSequence}">Não deve usar sequências lógicas como 123 ou ABC.</li>
                        <li>Caracteres especiais como @#%&$*_- reforçam a segurança da senha.</li>
                    </ul>
                </span>
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            Eu aceito os <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Termos de Uso</a> e a <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Política de Privacidade</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Já tem uma conta?
                </inertia-link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Cadastrar
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetInputPassword from '@/Jetstream/InputPassword'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetInputPassword,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        computed: {
            passwordNotEmpty() {
                return String(this.form.password).length;
            },
            lengthIsValid() {
                return String(this.form.password).length >= 6 && String(this.form.password).length <= 12;
            },
            isAlphaNumeric() {
                return /\d/g.test(this.form.password) && /[a-zA-Z]/g.test(this.form.password);
            },
            isLogicalSequence() {
                let matchNumbers = String(this.form.password).replace(/\D/g, '').split('');

                let sequence = false;

                matchNumbers.forEach((element, key) => {
                    let current = parseInt(element);
                    let next = parseInt(matchNumbers[key + 1]);

                    if(current + 1 === next || current - 1 === next) {
                        sequence = true;
                    }
                });

                return sequence;
            },
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
