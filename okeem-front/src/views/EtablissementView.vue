<template>
  <v-container>
    <v-card v-if="etablissement">
      <v-card-title>{{ etablissement.nom }}</v-card-title>
      <v-card-subtitle>Bienvenue !</v-card-subtitle>
      <v-card-text>
        <p>Type : {{ etablissement.type }}</p>
        <p>Lieu : {{ etablissement.lieu }}</p>
      </v-card-text>
      <v-card-actions>
        <v-btn
          color="primary"
          text="Accéder au tableau de bord"
          variant="Accéder au tableau de bord"
          :to="'/' + etablissement.slug + '/tableau-de-bord'"
        ></v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { useEtablissementStore } from '@/stores/useEtablissementStore'
import { storeToRefs } from 'pinia'
import { onMounted } from 'vue'

const route = useRoute()
const store = useEtablissementStore()
const { etablissement } = storeToRefs(store)

onMounted(async () => {
  if (route.params.etablissement) {
    await store.loadDataBySlug(route.params.etablissement)
  }
})
</script>
