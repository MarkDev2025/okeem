<template>
  <v-container>
    <v-card v-if="enfant" class="mx-auto mb-2">
      <v-row no-gutters>
        <v-col cols="auto">
          <v-avatar class="ma-3" size="100">
            <v-img :src="getChatonImagePath(enfant.id)" :alt="enfant.prenom"></v-img>
          </v-avatar>
        </v-col>
        <v-col>
          <v-card-title
            >{{ enfant.prenom }} {{ enfant.nom }}
            <span class="text-caption">(vue gestionnaire)</span></v-card-title
          >
          <v-card-text class="text-caption"
            >né(e) le {{ formatDateFR(enfant.date_naissance) }} <br />Age :
            {{ calculAge(enfant.date_naissance) }} mois <br />
            Depuis une semaine à "{{ etablissement.nom }}""
          </v-card-text>
          <v-card-content></v-card-content>
        </v-col>
      </v-row>
    </v-card>
    <v-alert v-else type="error">en cours de chargement...</v-alert>

    <v-card v-if="tuteurs.length" class="mx-auto mb-2">
      <v-card-title>Parents</v-card-title>
      <v-list>
        <v-list-item
          v-for="tuteur in tuteursAssocies"
          :key="tuteur.id"
          :to="`/${etablissement.slug}/parent/${tuteur.slug}`"
          class="pa-4"
        >
          <v-list-item-content class="">
            <div class="d-flex align-center">
              <v-avatar size="64" class="me-4">
                <v-img :src="`https://i.pravatar.cc/150?img=${tuteur.id}`" :alt="tuteur.prenom" />
              </v-avatar>
              <div>
                <v-list-item-title class="font-weight-medium">
                  {{ tuteur.prenom }} {{ tuteur.nom }}
                </v-list-item-title>
              </div>
            </div>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-card>

    <v-alert v-else type="info">Aucun enfant rattaché.</v-alert>

    <v-card v-if="transmissions.length">
      <v-card-title>Transmissions</v-card-title>
      <v-list>
        <v-list-item
          v-for="transmission in enfant.transmissions"
          :key="transmission.id"
          class="ml-md-16 ml-sm-2"
        >
          <v-list-item-content class="ps-0">
            <div>
              {{ formatTransmissionDate(transmission.jour) }} : <br />
              {{ transmission.message }} à {{transmission.heure_debut}} 
              <router-link
                :to="`/${etablissement.slug}/okeemien/${transmission.okeemien.slug}`"
                class="text-primary text-decoration-none"
              >
                <span class="text-caption text-grey-darken-1">
                  ({{ transmission.okeemien.prenom }} {{ transmission.okeemien.nom }})</span
                >
              </router-link>
            </div>
          </v-list-item-content>
          <v-divider class="mt-2"></v-divider>
        </v-list-item>
      </v-list>
    </v-card>
    <v-alert v-else type="info">Aucune transmission, ça va venir</v-alert>
  </v-container>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useEtablissementStore } from '@/stores/useEtablissementStore'
import { storeToRefs } from 'pinia'
import { getChatonImagePath } from '@/helpers/avatar'
import { formatTransmissionDate, formatDateFR, calculAge } from '@/helpers/formatTransmissionDate'

const route = useRoute()
const store = useEtablissementStore()
const { etablissement, enfants, tuteurs, okeemiens, transmissions } = storeToRefs(store)

// Vérifie si l'établissement est déjà dans le store, sinon le charge via le slug
onMounted(async () => {
  if (!etablissement.value || etablissement.value.slug !== route.params.etablissement) {
    await store.loadDataBySlug(route.params.etablissement)
  }
})

// Attendre que `tuteurs` soit chargé avant d'exécuter `find()`
const enfant = computed(() => {
  return enfants.value.find((t) => t.slug === route.params.slug_enfant)
})

// Récupération des enfants du tuteur sélectionné
const tuteursAssocies = computed(() =>
  tuteurs.value.filter((e) => e.enfants.some((t) => t.id === enfant.value?.id)),
)

// const transmissionsAssociees = computed(() =>
//   transmissions.value.filter(e => e.tuteurs.some(t => t.id === tuteur.value?.id))
// );
</script>
