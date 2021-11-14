<template>
    <div>
       
       <!-- Add Contact -->
        <jet-form-section @submitted="sendInvitation">
            <template #title>
                Convidar Usuário
            </template>

            <template #description>
                Envie um convite através do e-mail.
            </template>

            <template #form>
                
                <!-- Contact Name -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="name" value="Nome" />
                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="inviteForm.name" />
                    <jet-input-error :message="inviteForm.errors.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="email" value="E-mail" />
                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="inviteForm.email" />
                    <jet-input-error :message="inviteForm.errors.email" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="phone" value="Número de telefone" />
                    <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="inviteForm.phone" placeholder="Opcional" />
                    <jet-input-error :message="inviteForm.errors.phone" class="mt-2" />
                </div>

            </template>

            <template #actions>
                <jet-action-message :on="inviteForm.recentlySuccessful" class="mr-3">
                    Convite enviado.
                </jet-action-message>

                <jet-button :class="{ 'opacity-25': inviteForm.processing }" :disabled="inviteForm.processing">
                    Convidar
                </jet-button>
            </template>
        </jet-form-section>

        <div v-if="users.length > 0">
            <jet-section-border />

            <!-- Manage Contacts -->
            <jet-action-section class="mt-10 sm:mt-0">
                <template #title>
                    Lista de Usuários
                </template>

                <template #description>
                    Envie dinheiro e ativos facilmente a partir dos seus contatos favoritos.
                </template>

                <!-- Wallet Contact List -->
                <template #content>
                    <div class="space-y-6">
                        <div v-for="user in users" :key="user.id" class="w-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4>{{ user.name }}</h4>
                                    <p class="text-sm text-gray-400">{{ user.email }}</p>
                                </div>
                                <div class="flex items-center">
                                    <!-- Preview Contact Info -->
                                    <jet-button class="ml-2 mr-2" @click="manage(user)">
                                        <IdentificationIcon class="h-5 w-5" />
                                    </jet-button>

                                    <!-- Manage Contact Info -->
                                    <!-- <jet-secondary-button @click="preview(user)">
                                        <CogIcon class="h-5 w-5" />
                                    </jet-secondary-button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                

            </jet-action-section>

        </div>

        <!-- Contact Management Modal -->
        <jet-dialog-modal :show="currentlyManaging" @close="currentlyManaging = false">
            <template #title>
                {{ updateForm.name }}
            </template>

            <template #content>
                <div v-if="managingUser">
                    <!-- Contact Name -->
                    <div class="col-span-6 sm:col-span-4 mb-2">
                        <jet-label for="name" value="Nome" />

                        <jet-input id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="updateForm.name" />

                        <jet-input-error :message="updateForm.errors.name" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4 mb-2">
                        <jet-label for="email" value="E-mail" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="updateForm.email" placeholder="Opcional" />
                        <jet-input-error :message="updateForm.errors.email" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="phone" value="Número de telefone" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="updateForm.phone" placeholder="Opcional" />
                        <jet-input-error :message="updateForm.errors.phone" class="mt-2" />
                    </div>

                    <!-- Registered at -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="phone" value="Registrado em" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full bg-gray-100" v-model="updateForm.registered_at" readonly placeholder="Pendente" />
                        <jet-input-error :message="updateForm.errors.phone" class="mt-2" />
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="currentlyManaging = false">
                    Cancelar
                </jet-secondary-button>

                <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': updateForm.processing }" :disabled="updateForm.processing">
                    Editar
                </jet-button>
            </template>
        </jet-dialog-modal>

        <!-- Contact Preview Modal -->
        <jet-dialog-modal :show="currentlyPreview" @close="currentlyPreview = false">
            <template #title>
                Convite Enviado
            </template>

            <template #content>
                <!-- Contact Name -->
                <div class="col-span-6 sm:col-span-4 mb-2">
                    <jet-label for="name" value="Nome" />

                    <jet-input id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="updateForm.name" />

                    <jet-input-error :message="updateForm.errors.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-4 mb-2">
                    <jet-label for="email" value="E-mail" />
                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="updateForm.email" placeholder="Opcional" />
                    <jet-input-error :message="updateForm.errors.email" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="phone" value="Número de telefone" />
                    <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="updateForm.phone" placeholder="Opcional" />
                    <jet-input-error :message="updateForm.errors.phone" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="currentlyPreview = false">
                    Fechar
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <jet-http-error-dialog-modal 
            :show="currentlyHasError"
            :response="errorResponse"
            @close="currentlyHasError = false"
            heading="Há um problema com o convite" />

    </div>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetHttpErrorDialogModal from '@/Jetstream/HttpErrorDialogModal'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import { CogIcon, IdentificationIcon } from '@heroicons/vue/outline'

    export default {
        components: {
            JetDialogModal,
            JetHttpErrorDialogModal,
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetSecondaryButton,
            JetSectionBorder,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            CogIcon,
            IdentificationIcon,
        },

        props: ['users'],

        data() {
            return {
                managingUser: {},
                currentlyManaging: false,
                currentlyPreview: false,
                currentlyHasError: false,
                errorResponse: {},
                inviteForm: this.$inertia.form({
                    name: '',
                    email: '',
                    phone: '',
                }),
                updateForm: this.$inertia.form({
                    name: '',
                    email: '',
                    phone: '',
                    registered_at: ''
                }),
            }
        },

        methods: {

            sendInvitation() {
                let self = this;
                self.clearErrors();
                self.loading = true;
                axios.post(route('api.admin.users.invite'), {
                        name: self.inviteForm.name,
                        email: self.inviteForm.email,
                        phone: self.inviteForm.phone,
                    })
                     .then((response) => {
                         console.log('Response', response);
                         self.preview(response.data.data);
                         self.inviteForm.reset();
                         self.loading = false;
                     }).catch((error) => {
                        console.error('sendInvitation error response', error);
                        self.handleErrorResponse(error);
                     });
            },

            manage(user) {
                console.log('user', user);
                window.location.href = route('admin.users.show', user)
            },

            update() {
                this.updateForm.put(route('contacts.update', [this.managingUser]), {
                    preserveScroll: true,
                    onSuccess: () => (this.currentlyManaging = false),
                })
            },

            preview(user) {
                console.log('user', user);
                this.managingUser = user;
                this.currentlyPreview = true;
                let self = this;

                self.updateForm.name = user.name;
                self.updateForm.email = user.email;
                self.updateForm.phone = user.phone;
                self.updateForm.registered_at = user.registered_at;

            },

            clearErrors() {
                this.currentlyHasError = false;
                this.errorResponse = {};
            },

            handleErrorResponse(error) {
                let self = this;
                if (error.response) {
                    self.errorResponse = error.response.data;
                    _.each(self.errorResponse.errors, (error, idx) => {
                        _.each(error, (message) => {
                            self.inviteForm.errors[idx] = message;
                        });
                    });  
                }

                console.log('self.inviteForm.errors', self.inviteForm.errors);
                self.currentlyHasError = true;
            },

        },
    }
</script>


<style lang="css" scoped>
    input[disabled] {
        background-color: #f3f4f6;
    }
</style>