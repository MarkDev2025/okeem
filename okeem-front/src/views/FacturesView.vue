<template>
  <v-container>
    <v-card v-for="facture in factures" :key="facture.id">
      <v-card-title>Facture #{{ facture.id }}</v-card-title>
      <v-card-text>
        <p>Montant : {{ facture.montant }}€</p>
        <p>Statut : {{ facture.statut }}</p>
        <v-btn v-if="facture.pdf" color="primary" :href="facture.pdf" target="_blank">Télécharger PDF</v-btn>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue';
const factures = ref([
  { id: 101, montant: 150, statut: 'payée', pdf: 'https://example.com/facture101.pdf' }
]);
</script>
