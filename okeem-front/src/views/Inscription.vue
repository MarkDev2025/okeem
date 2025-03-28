<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" sm="8" md="6">
        <v-card elevation="2">
          <v-card-title>Inscription</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="submit" ref="form">
              <v-text-field
                v-model="form.prenom"
                label="Prénom"
                :rules="nameRules"
                required
                variant="outlined"
              ></v-text-field>
              <v-text-field
                v-model="form.email"
                label="Email"
                type="email"
                :rules="emailRules"
                required
                variant="outlined"
              ></v-text-field>
              <v-text-field
                v-model="form.password"
                label="Mot de passe"
                type="password"
                :rules="passwordRules"
                required
                variant="outlined"
              ></v-text-field>
              <v-btn 
                type="submit" 
                color="primary" 
                block 
                class="mt-4"
                :loading="loading"
                :disabled="loading"
              >
                S'inscrire
              </v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-snackbar v-model="snackbar" :color="snackbarColor">
      {{ snackbarText }}
    </v-snackbar>
  </v-container>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

interface FormData {
  prenom: string;
  email: string;
  password: string;
}

export default defineComponent({
  name: 'Inscription',
  setup() {
    const form = ref<FormData>({
      prenom: '',
      email: '',
      password: ''
    });
    
    const formRef = ref(null);
    const loading = ref(false);
    const snackbar = ref(false);
    const snackbarText = ref('');
    const snackbarColor = ref('');
    
    const nameRules = [
      (v: string) => !!v || 'Le prénom est requis',
      (v: string) => v.length >= 2 || 'Le prénom doit contenir au moins 2 caractères'
    ];
    
    const emailRules = [
      (v: string) => !!v || 'L\'email est requis',
      (v: string) => /.+@.+\..+/.test(v) || 'L\'email doit être valide'
    ];
    
    const passwordRules = [
      (v: string) => !!v || 'Le mot de passe est requis',
      (v: string) => v.length >= 6 || 'Le mot de passe doit contenir au moins 6 caractères'
    ];
    
    const submit = async () => {
      loading.value = true;
      
      try {
        // Simulation pour test
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Code réel:
        // const response = await fetch('/api/inscription', {
        //   method: 'POST',
        //   headers: { 'Content-Type': 'application/json' },
        //   body: JSON.stringify(form.value)
        // });
        // const data = await response.json();
        
        snackbarText.value = 'Inscription réussie !';
        snackbarColor.value = 'success';
        form.value = { prenom: '', email: '', password: '' };
      } catch (error) {
        snackbarText.value = 'Erreur lors de l\'inscription';
        snackbarColor.value = 'error';
      } finally {
        loading.value = false;
        snackbar.value = true;
      }
    };
    
    return {
      form,
      formRef,
      nameRules,
      emailRules,
      passwordRules,
      loading,
      snackbar,
      snackbarText,
      snackbarColor,
      submit
    };
  }
});
</script>