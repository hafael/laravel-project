<template>

    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contatos
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <!-- Add Contact -->
            <jet-form-section @submitted="addContact">
                <template #title>
                    Novo contato
                </template>

                <template #description>
                    Guarde informações sobre os seus contatos para usar em transações como pagamentos. <br />
                    
                </template>

                <template #form>
                    
                    <!-- Contact Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="name" value="Nome" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="addContactForm.name" />
                        <jet-input-error :message="addContactForm.errors.name" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="lastname" value="Sobrenome ou apelido" />
                        <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="addContactForm.lastname" placeholder="Opcional" />
                        <jet-input-error :message="addContactForm.errors.lastname" class="mt-2" />
                    </div>

                    <!-- Wallet Address -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="wallet_address" value="Endereço da conta" />
                        <jet-input id="wallet_address" type="text" class="mt-1 block w-full" v-model="addContactForm.wallet_address" />
                        <jet-input-error :message="addContactForm.errors.wallet_address" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="email" value="E-mail" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="addContactForm.email" placeholder="Opcional" />
                        <jet-input-error :message="addContactForm.errors.email" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="phone" value="Número de telefone" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="addContactForm.phone" placeholder="Opcional" />
                        <jet-input-error :message="addContactForm.errors.phone" class="mt-2" />
                    </div>

                </template>

                <template #actions>
                    <jet-action-message :on="recentlySuccessful" class="mr-3">
                        Contato salvo.
                    </jet-action-message>

                    <jet-button :class="{ 'opacity-25': addContactForm.processing }" :disabled="addContactForm.processing">
                        Salvar
                    </jet-button>
                </template>
            </jet-form-section>
        </div>

        <jet-http-error-dialog-modal 
            :show="recentlyError"
            :response="errorResponse"
            @close="recentlyError = false"
            heading="Falha ao salvar o contato" />

    </app-layout>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetHttpErrorDialogModal from '@/Jetstream/HttpErrorDialogModal'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import { QrcodeIcon } from '@heroicons/vue/outline'

    export default {
        components: {
            AppLayout,
            JetActionMessage,
            JetHttpErrorDialogModal,
            JetButton,
            JetSecondaryButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            QrcodeIcon
        },

        props: ['contacts'],

        data() {
            return {
                recentlySuccessful: false,
                addContactForm: this.$inertia.form({
                    name: '',
                    lastname: '',
                    wallet_address: '',
                    email: '',
                    phone: '',
                }),
                recentlyError: false,
                errorResponse: {}
            }
        },

        computed: {
            addContactFormSubmitData() {
                return {
                    name: this.addContactForm.name,
                    lastname: this.addContactForm.lastname,
                    wallet_address: this.addContactForm.wallet_address,
                    email: this.addContactForm.email,
                    phone: this.addContactForm.phone,
                }
            }
        },

        methods: {

            addContact() {
                
                let self = this;
                self.loading = true;
                self.recentlySuccessful = false;

                axios.post(route('api.contacts.store'), self.addContactFormSubmitData).then((response) => {
                    console.log('response', response);
                    self.recentlySuccessful = true;
                    self.addContactForm.reset()
                }).catch((error) => {
                    console.error(error);
                    self.loading = false;
                    self.handleErrorResponse(error);
                });
            },

            handleErrorResponse(error) {
                let self = this;
                if (error.response) {
                    self.errorResponse = error.response.data;
                    _.each(self.errorResponse.errors, (error, idx) => {
                        _.each(error, (message) => {
                            self.addContactForm.errors[idx] = message;
                        });
                    });  
                }
                self.recentlyError = true;
            }

        },
    }
</script>
