<template>
  <v-container>
    <v-card v-if="tuteur" class="mx-auto mb-2">
      <v-row no-gutters>
        <v-col cols="auto">
          <v-avatar class="ma-3" size="100">
            <v-img :src="`https://i.pravatar.cc/150?img=${tuteur.id}`" :alt="tuteur.prenom"></v-img>
          </v-avatar>
        </v-col>
        <v-col>
          <v-card-title>{{ tuteur.prenom }} {{ tuteur.nom }} <span class="text-caption">(vue parent)</span></v-card-title>
          <v-card-subtitle>{{ tuteur.email }}</v-card-subtitle>
          <v-card-subtitle>Tel: {{ tuteur.telephone }}</v-card-subtitle>
        </v-col>
      </v-row>
    </v-card>
    <v-alert v-else type="error">en cours de chargement...</v-alert>

    <v-card v-if="enfants.length" class="mx-auto mb-2">
    <v-card-title>Enfants</v-card-title>
      <v-list>
        <v-list-item
          v-for="enfant in enfantsAssocies"
          :key="enfant.id"
          :to="`/${etablissement.slug}/enfant/${enfant.slug}`"
          class="pa-4 no-hover"
        >
          <v-list-item-content class="no-hover">
            <div class="d-flex align-center">
              <v-avatar size="64" class="me-4">
                <v-img
                  :src="getChatonImagePath(enfant.id)"
                  :alt="`${enfant.prenom} ${enfant.nom}`"
                />
              </v-avatar>
              <div>
                <v-list-item-title class="font-weight-medium">
                  {{ enfant.prenom }} {{ enfant.nom }}
                </v-list-item-title>
                <v-list-item-subtitle class="text-teal-darken-2">
                  Transmissions :
                </v-list-item-subtitle>
              </div>
            </div>
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
                    <span class="text-caption text-grey-darken-1">({{ transmission.okeemien.nom }})</span>
                  </div>
                </v-list-item-content>
                 <v-divider class="mt-2"></v-divider>
              </v-list-item>
            </v-list>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-card>

    <v-alert v-else type="info">Aucun enfant rattaché.</v-alert>
    <v-card v-if="facturesAssociees.length" class="mx-auto mb-2">
    <v-card-title>Factures</v-card-title>
      <v-list>
        <v-list-item>
          <v-card>           
            <v-list>
              <v-list-item v-for="facture in facturesAssociees" :key="facture.id" class="ml-16">
                 <v-list-item-title>Facture n° {{ facture.id }}</v-list-item-title>
                {{ facture.montant }} € - {{ facture.statut }}
              </v-list-item>
            </v-list>
          </v-card>
        </v-list-item>
      </v-list>
    </v-card>
    <v-alert v-else type="info">Aucune facture rattachée.</v-alert>
  </v-container>
</template>
<script setup>
import { computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useEtablissementStore } from '@/stores/useEtablissementStore';
import { storeToRefs } from 'pinia';
import { getChatonImagePath } from '@/helpers/avatar';
import { formatTransmissionDate } from '@/helpers/formatTransmissionDate';

const route = useRoute();
const store = useEtablissementStore();
const { etablissement, enfants, tuteurs, okeemiens, transmissions, factures } = storeToRefs(store);

onMounted(async () => {
  if (!etablissement.value || etablissement.value.slug !== route.params.etablissement) {
    await store.loadDataBySlug(route.params.etablissement);
  }
});

const tuteur = computed(() => {
  return tuteurs.value.find(t => t.slug === route.params.slug_parent);
});

// const enfantsAssocies = computed(() =>
//   enfants.value.filter(e => e.tuteurs.some(t => t.id === tuteur.value?.id))
// );

const facturesAssociees = computed(() =>  
  factures.value.filter(e => e.tuteur?.id === tuteur.value?.id)
);

const enfantsAssocies = computed(() =>
  enfants.value
    .filter(e => e.tuteurs.some(t => t.id === tuteur.value?.id))
    .map(e => ({
      ...e,
      transmissions: [...e.transmissions].sort((a, b) =>
        b.jour.localeCompare(a.jour)
      ),
    }))
);

</script>
