<template>
    <div>
       
        <!-- Manage Contacts -->
        <jet-action-section class="mt-10 sm:mt-0">
            <template #title>
                Lista de Contatos
            </template>

            <template #description>
                Envie dinheiro e ativos facilmente a partir dos seus contatos favoritos. <br />
                <jet-button :href="route('contacts.create')" class="mt-2">
                    Novo contato
                </jet-button>
            </template>

            <!-- Wallet Contact List -->
            <template #content>
                <div class="space-y-6">
                    <div v-for="contact in contacts" :key="contact.id" class="w-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4>{{ contact.name }}</h4>
                                <p class="text-sm text-gray-400">{{ $filters.limitTo(contact.wallet_address, 20) }}</p>
                            </div>
                            <div class="flex items-center">
                                <!-- Preview Contact Info -->
                                <!-- <jet-button class="ml-2 mr-2" @click="previewContact(contact)">
                                    <IdentificationIcon class="h-5 w-5" />
                                </jet-button> -->

                                <!-- Manage Contact Info -->
                                <jet-secondary-button @click="manageContact(contact)">
                                    <IdentificationIcon class="h-5 w-5" />
                                </jet-secondary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            

        </jet-action-section>

        <!-- Contact Management Modal -->
        <jet-dialog-modal :show="currentlyManagingContact" @close="currentlyManagingContact = false">
            <template #title>
                Contato de {{ updateContactForm.name }}
            </template>

            <template #content>
                <div v-if="managingContact">
                    <!-- Contact Name -->
                    <div class="col-span-6 sm:col-span-4 mb-2">
                        <jet-label for="name" value="Nome" />

                        <jet-input id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="updateContactForm.name" />

                        <jet-input-error :message="updateContactForm.errors.name" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div class="col-span-6 sm:col-span-4 mb-2">
                        <jet-label for="last_name" value="Sobrenome ou apelido" />

                        <jet-input id="last_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="updateContactForm.last_name" />

                    </div>

                    <!-- Wallet Address -->
                    <div class="col-span-6 sm:col-span-4 mt-2 mb-2">
                        <jet-label for="wallet_address" value="Endereço da carteira" />

                        <jet-input id="wallet_address"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="updateContactForm.wallet_address"/>
                    </div>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4 mb-2">
                        <jet-label for="email" value="E-mail" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="updateContactForm.email" placeholder="Opcional" />
                        <jet-input-error :message="updateContactForm.errors.email" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="phone" value="Número de telefone" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="updateContactForm.phone" placeholder="Opcional" />
                        <jet-input-error :message="updateContactForm.errors.phone" class="mt-2" />
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="currentlyManagingContact = false">
                    Cancelar
                </jet-secondary-button>

                <jet-button class="ml-2" @click="updateContact" :class="{ 'opacity-25': updateContactForm.processing }" :disabled="updateContactForm.processing">
                    Salvar
                </jet-button>
            </template>
        </jet-dialog-modal>

        <!-- Contact Preview Modal -->
        <jet-dialog-modal :show="currentlyPreviewContact" @close="currentlyPreviewContact = false">
            <template #title>
                {{ managingContact.name }}
            </template>

            <template #content>

            </template>

            <template #footer>
                <jet-secondary-button @click="currentlyPreviewContact = false">
                    Fechar
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

    </div>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import { IdentificationIcon } from '@heroicons/vue/outline'

    export default {
        components: {
            JetDialogModal,
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetSecondaryButton,
            JetSectionBorder,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            IdentificationIcon,
        },

        props: ['contacts'],

        data() {
            return {
                managingContact: {},
                currentlyManagingContact: false,
                currentlyPreviewContact: false,
                addContactForm: this.$inertia.form({
                    name: '',
                    last_name: '',
                    wallet_address: '',
                    email: '',
                    phone: '',
                }),
                updateContactForm: this.$inertia.form({
                    name: '',
                    last_name: '',
                    wallet_address: '',
                    email: '',
                    phone: '',
                }),
            }
        },

        methods: {

            addContact() {
                this.addContactForm.post(route('contacts.store'), {
                    errorBag: 'addContact',
                    preserveScroll: true,
                    onSuccess: () => this.addContactForm.reset(),
                });
            },

            manageContact(contact) {
                console.log('contact', contact);
                this.managingContact = contact;
                this.updateContactForm.name = contact.name;
                this.updateContactForm.wallet_address = contact.wallet_address;
                this.currentlyManagingContact = true;
            },

            updateContact() {
                this.updateContactForm.put(route('contacts.update', [this.managingContact]), {
                    preserveScroll: true,
                    onSuccess: () => (this.currentlyManagingContact = false),
                })
            },

            previewContact(contact) {
                console.log('contact', contact);
                this.managingContact = contact;
                this.currentlyPreviewContact = true;
                let self = this;

                axios.get(route('api.contacts.show', contact))
                     .then((response) => {
                         console.log('Response', response);
                         self.managingContact = response.data;
                     });
            },

        },
    }
</script>


<style lang="css" scoped>
    input[disabled] {
        background-color: #f3f4f6;
    }
</style>