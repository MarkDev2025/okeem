<template>
  <v-container>
    <v-form>
      <v-textarea v-model="message" label="Message" outlined></v-textarea>
      <v-file-input label="Fichier optionnel" v-model="file"></v-file-input>
      <v-btn color="primary" @click="envoyerTransmission">Envoyer</v-btn>
    </v-form>
  </v-container>
</template>

<script setup>
import { ref } from 'vue';
const message = ref('');
const file = ref(null);

const envoyerTransmission = () => {
  console.log('Transmission envoyée:', { message: message.value, file: file.value });
};
</script>
