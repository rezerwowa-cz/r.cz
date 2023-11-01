<script setup>
import AppLayout from '@/Layouts/Default.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Edycja profilu">
        <div class="">
          <div class="p-6 pt-12 pb-12">
            <div class="flex items-center justify-start">
              <div class="flex flex-col items-start gap-y-6">
                <h5 class="">Edycja danych użytkownika</h5>
              </div>
            </div>
          </div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.user" />

                    <JetSectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
