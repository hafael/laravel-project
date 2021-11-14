<template>
    <jet-form-section @submitted="updateProfile">
        <template #title>
            Cadastro
        </template>

        <template #description>
            Perfil do usuário
        </template>

        <template #form>
            
            <!-- Profile photo -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="photo" value="Foto do perfil" />
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="!photoPreview">
                    <img :src="user.profile_photo_url" :alt="userForm.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Nova foto
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remover foto
                </jet-secondary-button>
                <jet-input-error :message="userForm.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="userForm.name" />
                <jet-input-error :message="userForm.errors.name" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="lastname" value="Sobrenome" />
                <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="userForm.lastname" />
                <jet-input-error :message="userForm.errors.lastname" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="E-mail de acesso" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="userForm.email" placeholder="Opcional" />
                <jet-input-error :message="userForm.errors.email" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Número de telefone com código de área" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="userForm.phone" placeholder="(55) 99999-9999 (Opcional)" />

                <jet-input-error :message="userForm.errors.phone" class="mt-2" />
            </div>

            <!-- Birthdate -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="birthdate" value="Data de Nascimento" />
                <jet-input id="birthdate" type="date" class="mt-1 block w-full" v-model="userForm.birthdate" placeholder="AAAA-MM-DD" />
                <jet-input-error :message="userForm.errors.birthdate" class="mt-2" />
            </div>

            <!-- Lang -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="language" value="Linguagem" />
                <jet-select id="language" class="mt-1 block w-full" v-model="userForm.language" :options="languageOptions" />
                <jet-input-error :message="userForm.errors.language" class="mt-2" />
            </div>

            <!-- Currency -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="country" value="Moeda" />
                <jet-select id="currency" class="mt-1 block w-full" v-model="userForm.currency" :options="currencyOptions" />
                <jet-input-error :message="userForm.errors.currency" class="mt-2" />
            </div>

            <!-- País -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="country" value="País" />
                <jet-select id="country" class="mt-1 block w-full" v-model="userForm.country" :options="countryOptions" />
                <jet-input-error :message="userForm.errors.country" class="mt-2" />
            </div>

            <!-- Network Ledger -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_network" value="Ledger" />
                <jet-select id="current_network" class="mt-1 block w-full" v-model="userForm.current_network" :options="networkOptions" />
                <jet-input-error :message="userForm.errors.current_network" class="mt-2" />
            </div>

            <!-- Spend Limit Code -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="spend_limit_code" value="Limites de Recursos" />
                <jet-select id="spend_limit_code" class="mt-1 block w-full" v-model="userForm.spend_limit_code" :options="spendLimitOptions" />
                <jet-input-error :message="userForm.errors.spend_limit_code" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <jet-action-message :on="recentlySuccessful" class="mr-3">
                Atualizado
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': userForm.processing }" :disabled="userForm.processing">
                Salvar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSelect from '@/Jetstream/Select'
    import JetActionMessage from '@/Jetstream/ActionMessage'

    export default {
        components: {
            JetButton,
            JetSecondaryButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSelect,
            JetActionMessage,
        },
        props: ['user'],

        data() {
            return {
                photoPreview: null,
                userForm: this.$inertia.form({
                    name: '',
                    lastname: '',
                    email: '',
                    phone: '',
                    photo: null,
                    lang: '',
                    currency: '',
                    country: '',
                    birthdate: null,
                    current_network: null,
                    spend_limit_code: 'DEMO_TIER'
                }),
                recentlySuccessful: false
            }
        },

        mounted() {
            this.fillData(this.user);
        },
        
        computed: {
            countryOptions() {
                return [{
                    text: 'Brasil',
                    value: 'BRA'
                }];
            },
            languageOptions() {
                return [{
                    text: 'Português (Brasil)',
                    value: 'pt_BR'
                }];
            },
            currencyOptions() {
                return [{
                    text: 'Reais (R$)',
                    value: 'BRL'
                }];
            },
            networkOptions() {
                return [{
                    text: 'MainNet',
                    value: 'MainNet'
                },{
                    text: 'TestNet',
                    value: 'TestNet'
                }];
            },
            spendLimitOptions() {
                return [{
                    text: 'Apresentação',
                    value: 'DEMO_TIER'
                },{
                    text: 'Faixa 1',
                    value: 'TIER_1'
                }];
            }
        },

        methods: {
            fillData(data) {
                this.userForm.name = data.name;
                this.userForm.lastname = data.lastname;
                this.userForm.email = data.email;
                this.userForm.phone = data.phone;
                this.userForm.language = data.language;
                this.userForm.currency = data.currency;
                this.userForm.birthdate = data.birthdate;
                this.userForm.country = data.country;
                this.userForm.current_network = data.current_network;
                this.userForm.spend_limit_code = data.spend_limit_code;
            },
            updateProfile() {
                let self = this;

                self.loading = true;

                axios.put(route('api.admin.users.update', [this.user]), {
                    name: self.userForm.name,
                    lastname: self.userForm.lastname,
                    email: self.userForm.email,
                    phone: self.userForm.phone,
                    birthdate: self.userForm.birthdate,
                    language: self.userForm.language,
                    currency: self.userForm.currency,
                    country: self.userForm.country,
                    spend_limit_code: self.userForm.spend_limit_code,
                }).then((response) => {
                    self.loading = false
                })
                .catch((error) => {
                    console.error(error);
                    self.loading = false
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    },
                });
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        },
    }
</script>
