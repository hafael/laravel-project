<template>
    <jet-action-section>
        <template #title>
            Limites de Recursos
        </template>

        <template #description>
            Informações sobre limitações dos recursos da sua conta.
        </template>

        <template #content>
            
            <table class="table-fixed w-full">
                <thead class="border-b-2 border-gray-250">
                    <tr>
                        <th class="w-1/2 text-left">Recurso</th>
                        <th class="w-1/4">Atual</th>
                        <th class="w-1/4">Limite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="limits.wallets_count" class="border-b border-gray-200">
                        <td>Contas</td>
                        <td class="text-center">{{ limits.wallets_count.current }}</td>
                        <td class="text-center">{{ limits.wallets_count.limit }}</td>
                    </tr>
                    <tr v-if="limits.contacts_count" class="border-b border-gray-200">
                        <td>Contatos</td>
                        <td class="text-center">{{ limits.contacts_count.current }}</td>
                        <td class="text-center">{{ limits.contacts_count.limit }}</td>
                    </tr>
                    <tr v-if="limits.max_deposit_amount" class="border-b border-gray-200">
                        <td>Máx. por Depósito</td>
                        <td class="text-center"></td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.max_deposit_amount.limit) }}</td>
                    </tr>
                    <tr v-if="limits.daily_deposits_amount" class="border-b border-gray-200">
                        <td>Depósitos Diário</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.daily_deposits_amount.current) }}</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.daily_deposits_amount.limit) }}</td>
                    </tr>
                    <tr v-if="limits.monthly_deposits_amount" class="border-b border-gray-200">
                        <td>Depósitos Mensal</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.monthly_deposits_amount.current) }}</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.monthly_deposits_amount.limit) }}</td>
                    </tr>
                    <tr v-if="limits.max_deposit_amount" class="border-b border-gray-200">
                        <td>Máx. por Transferência</td>
                        <td class="text-center text-sm"></td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.max_transfer_amount.limit) }}</td>
                    </tr>
                    <tr v-if="limits.daily_transfers_amount" class="border-b border-gray-200">
                        <td>Transferências Diário</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.daily_transfers_amount.current) }}</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.daily_transfers_amount.limit) }}</td>
                    </tr>
                    <tr v-if="limits.monthly_transfers_amount">
                        <td>Transferências Mensal</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.monthly_transfers_amount.current) }}</td>
                        <td class="text-center text-sm">{{ $filters.reaisFromCents(limits.monthly_transfers_amount.limit) }}</td>
                    </tr>
                </tbody>
            </table>

            
        </template>

    </jet-action-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetActionSection from '@/Jetstream/ActionSection'
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
            JetActionSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSelect,
            JetSecondaryButton,
        },

        props: ['user'],
        

        data() {
            return {
                limits: {},
            }
        },

        computed: {
            
        },

        mounted() {
            this.fetch();
        },

        methods: {
            fetch() {
                let self = this;

                axios.get(route('api.account.limits'))
                     .then((response) => {
                         console.log('Limits response', response);
                         self.limits = response.data;
                     });
            },
        },
    }
</script>
