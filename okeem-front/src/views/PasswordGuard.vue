<!-- src/views/PasswordGuard.vue -->
<template>
  <v-container class="text-center">
    <v-card class="mx-auto my-12 pa-6" max-width="400">
      <v-card-title class="text-h6">Accès protégé</v-card-title>
      <v-text-field
        v-model="password"
        label="Mot de passe"
        type="password"
        outlined
        class="my-4"
      />
      <v-btn color="primary" @click="verifierMotDePasse">Accéder</v-btn>
      <v-alert v-if="erreur" type="error" class="mt-4">Mot de passe incorrect</v-alert>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import SHA256 from 'crypto-js/sha256'

const password = ref('')
const erreur = ref(false)
const router = useRouter()

const hashAttendu = '798b05c4c8e5a7d17ebb8ece76e281693941463483e1950295a4d83288330291'

function verifierMotDePasse() {
  const hashHex = SHA256(password.value).toString()

  if (hashHex === hashAttendu) {
    localStorage.setItem('acces_autorise', 'true')
    router.push('/')
  } else {
    erreur.value = true
  }
}
</script>
