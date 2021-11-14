<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Informações do perfil
        </template>

        <template #description>
            Atualize as informações principais da sua conta.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
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

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Lastname -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="lastname" value="Sobrenome" />
                <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" autocomplete="lastname" />
                <jet-input-error :message="form.errors.lastname" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="E-mail" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Número de telefone pessoal" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" autocomplete="phone" />
                <jet-input-error :message="form.errors.phone" class="mt-2" />
            </div>

            <!-- Birthdate -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="birthdate" value="Data de Nascimento" />
                <jet-input id="birthdate" type="date" class="mt-1 block w-full" v-model="form.birthdate" placeholder="AAAA-MM-DD" />
                <jet-input-error :message="form.errors.birthdate" class="mt-2" />
            </div>

            <!-- Lang -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="language" value="Linguagem" />
                <jet-select id="language" class="mt-1 block w-full" v-model="form.language" :options="languageOptions" />
                <jet-input-error :message="form.errors.language" class="mt-2" />
            </div>

            <!-- Currency -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="country" value="Moeda" />
                <jet-select id="currency" class="mt-1 block w-full" v-model="form.currency" :options="currencyOptions" />
                <jet-input-error :message="form.errors.currency" class="mt-2" />
            </div>

            <!-- País -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="country" value="País" />
                <jet-select id="country" class="mt-1 block w-full" v-model="form.country" :options="countryOptions" />
                <jet-input-error :message="form.errors.country" class="mt-2" />
            </div>

            <!-- Network Ledger -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_network" value="Ledger" />
                <jet-select id="current_network" class="mt-1 block w-full" v-model="form.current_network" :options="networkOptions" />
                <jet-input-error :message="form.errors.current_network" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Salvo.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Salvar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSelect from '@/Jetstream/Select'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSelect,
            JetSecondaryButton,
        },

        props: ['user'],
        

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    lastname: this.user.lastname,
                    email: this.user.email,
                    phone: this.user.phone,
                    photo: null,
                    language: this.user.language,
                    currency: this.user.currency,
                    country: this.user.country,
                    birthdate: this.user.birthdate,
                    current_network: this.user.current_network
                }),

                photoPreview: null,
            }
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
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
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
