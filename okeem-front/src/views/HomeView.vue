<template>
  <v-app>
    <v-app-bar app color="primary" dark>
      <v-toolbar-title>
        <router-link to="#" @click="ouvrirSelectionEtablissement" style="text-decoration: none; color: inherit;">Okeem</router-link>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn :to="'/' + etablissement + '/tableau-de-bord'">Tableau de Bord</v-btn>
      <v-btn :to="'/' + etablissement + '/parent'">Parents</v-btn>
      <v-btn :to="'/' + etablissement + '/okeemien'">Éducateurs</v-btn>
      <v-btn :to="'/' + etablissement + '/' + enfant + '/transmissions'">Transmissions</v-btn>
    </v-app-bar>
    <v-main>
      <router-view></router-view>
      <v-dialog v-model="dialog" max-width="400">
        <v-card>
          <v-card-title>Sélectionnez un établissement</v-card-title>
          <v-card-text>
            <v-select v-model="etablissement" :items="etablissements" label="Établissements" outlined></v-select>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="validerEtablissement">Valider</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-main>
  </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const etablissement = ref('');
const enfant = ref('enfant-test');
const dialog = ref(true);
const etablissements = ref(['Creche-Etoile', 'Creche-Soleil', 'Creche-Lune']);

const ouvrirSelectionEtablissement = () => {
  dialog.value = true;
};

const validerEtablissement = () => {
  if (etablissement.value) {
    dialog.value = false;
    router.push('/' + etablissement.value);
  }
};
</script>
