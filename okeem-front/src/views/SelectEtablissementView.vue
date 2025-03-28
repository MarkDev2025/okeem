<template>
  <v-container>
    <v-card>
      <v-card-title>Sélectionnez un établissement</v-card-title>
      <v-card-text>
        <v-select v-model="selectedEtablissement" :items="etablissements.map(e => e.nom)" label="Établissements" outlined></v-select>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="validerEtablissement">Valider</v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useEtablissementStore } from '@/stores/useEtablissementStore';
import { storeToRefs } from 'pinia';

const router = useRouter();
const store = useEtablissementStore();
const { etablissements, etablissement } = storeToRefs(store); // Récupération correcte des valeurs réactives
const selectedEtablissement = ref('');

// const validerEtablissement = () => {
//   const etab = etablissements.value.find(e => e.nom === selectedEtablissement.value);
//   if (etab) {
//     store.setEtablissement(etab); // Stocke l'objet complet pour l'utiliser partout
//     router.push('/' + etab.nom);
//   }
// };

const validerEtablissement = () => {
  const etab = etablissements.value.find(e => e.nom === selectedEtablissement.value);
  if (etab) {
    store.loadDataBySlug(etab.slug);
    router.push('/' + etab.slug);
  }
};

onMounted(async () => {
  await store.fetchEtablissements();
});
</script>

