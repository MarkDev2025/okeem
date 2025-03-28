<template>
  <v-container>
    <v-card v-if="okeemien" class="mx-auto mb-2">
      <v-row no-gutters>
        <v-col cols="auto">
          <v-avatar class="ma-3" size="100">
            <v-img
              :src="getAvatarUrl('okeemien.png')"
              :alt="okeemien.prenom"
            ></v-img>
          </v-avatar>
        </v-col>
        <v-col>
          <v-card-title
            >{{ okeemien.prenom }} {{ okeemien.nom }}
            <span class="text-caption mb-2">(vue gestionnaire)</span></v-card-title
          >
          <v-card-subtitle>{{ okeemien.email }}</v-card-subtitle>
          <v-card-subtitle>Tel: {{ okeemien.telephone }}</v-card-subtitle>
        </v-col>
      </v-row>
    </v-card>
    <v-alert v-else type="error">en cours de chargement...</v-alert>

    <v-card class="mx-auto mb-2" elevation="2">
      <v-card-title>Créer une transmission</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="ajouterTransmission">
          <v-row dense>
            <v-col cols="12">
              <v-select
                v-model="selectedEnfant"
                :items="enfants.map((e) => ({ title: e.nom, value: e.id }))"
                label="Sélectionner un enfant"
                outlined
                dense
                required
              ></v-select>
            </v-col>

            <v-col cols="12">
              <v-textarea
                v-model="nouvelleTransmission.message"
                label="Message"
                outlined
                auto-grow
                dense
                rows="2"
                required
              ></v-textarea>
            </v-col>

            <v-col cols="12" md="4">
              <v-text-field
                v-model="nouvelleTransmission.jour"
                label="Date"
                type="date"
                outlined
                dense
                required
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4">
              <v-text-field
                v-model="nouvelleTransmission.heure_debut"
                label="Heure de début"
                type="time"
                outlined
                dense
                required
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4">
              <v-text-field
                v-model="nouvelleTransmission.heure_fin"
                label="Heure de fin"
                type="time"
                outlined
                dense
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-btn type="submit" color="primary" class="mt-4">Envoyer</v-btn>
        </v-form>
      </v-card-text>
    </v-card>

<v-card v-if="okeemien && transmissionsAssociees.length" class="mx-auto mb-2" elevation="2">
  <v-card-title>Transmissions</v-card-title>
  <v-card-text>
    <v-list>
      <v-list-item
        v-for="transmission in transmissionsAssociees"
        :key="transmission.id"
        class="pa-0"
      >
        <v-card class="ma-2" elevation="1">
          <v-card-title class="text-subtitle-1 font-weight-medium">
            {{ transmission.message }}
          </v-card-title>

          <v-card-subtitle>
            Enfant :
            <router-link
              :to="`/${etablissement.slug}/enfant/${transmission.enfant.slug}`"
              class="text-primary text-decoration-none"
            >
              {{ transmission.enfant.prenom }} {{ transmission.enfant.nom }}
            </router-link>
          </v-card-subtitle>

          <v-card-text class="pt-0">
            <v-row dense>
              <v-col cols="12" sm="4">
                <p class="mb-1"><strong>Date :</strong> {{ transmission.jour }}</p>
              </v-col>
              <v-col cols="12" sm="4">
                <p class="mb-1"><strong>Heure début :</strong> {{ transmission.heure_debut }}</p>
              </v-col>
              <v-col cols="12" sm="4">
                <p class="mb-1"><strong>Heure fin :</strong> {{ transmission.heure_fin }}</p>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-actions>
            <v-btn color="warning" variant="tonal" @click="ouvrirPopupModification(transmission)">
              Modifier
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-list-item>
    </v-list>
  </v-card-text>
</v-card>

<v-alert v-else type="info">Aucune transmission enregistrée.</v-alert>


    <!-- Popup de modification -->
    <v-dialog v-model="popupModification" max-width="500px">
      <v-card>
        <v-card-title>Modifier la transmission</v-card-title>
        <v-card-text>
          <v-textarea v-model="modifTransmission.message" label="Message" outlined></v-textarea>
          <v-text-field
            v-model="modifTransmission.jour"
            label="Date"
            type="date"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="modifTransmission.heure_debut"
            label="Heure de début"
            type="time"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="modifTransmission.heure_fin"
            label="Heure de fin"
            type="time"
            outlined
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" @click="modifierTransmission">Enregistrer</v-btn>
          <v-btn color="secondary" @click="popupModification = false">Annuler</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { useEtablissementStore } from '@/stores/useEtablissementStore'
import { computed, onMounted, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { getAvatarUrl } from '@/config'

const route = useRoute()
const store = useEtablissementStore()
const { etablissement, enfants, okeemiens, transmissions } = storeToRefs(store)

const selectedEnfant = ref(null)
const nouvelleTransmission = ref({ message: '', jour: '', heure_debut: '', heure_fin: '' })
const popupModification = ref(false)
const modifTransmission = ref({ id: null, message: '', jour: '', heure_debut: '', heure_fin: '' })

onMounted(async () => {
  if (!etablissement.value || etablissement.value.slug !== route.params.etablissement) {
    await store.loadDataBySlug(route.params.etablissement)
  }
  const now = new Date()

  // date au format yyyy-mm-dd
  const dateStr = now.toISOString().split('T')[0]

  // heure actuelle au format HH:mm
  const heureDebut = now.toTimeString().slice(0, 5)

  const plusUneHeure = new Date(now.getTime() + 60 * 60 * 1000)
  const heureFin = plusUneHeure.toTimeString().slice(0, 5)

  nouvelleTransmission.value.jour = dateStr
  nouvelleTransmission.value.heure_debut = heureDebut
  nouvelleTransmission.value.heure_fin = heureFin
})

const okeemien = computed(() => {
  return okeemiens.value.find((t) => t.slug === route.params.slug_okeemien)
})
const transmissionsAssociees = computed(() => {
  if (!okeemien.value?.id) return []
  return transmissions.value.filter((e) => e.okeemien?.id === okeemien.value?.id)
})

const updateTransmissionsAssociees = () => {
  if (okeemien.value?.id) {
    transmissionsAssociees.value = transmissions.value.filter(
      (e) => e.okeemien?.id === okeemien.value.id,
    )
  } else {
    transmissionsAssociees.value = []
  }
}

const ajouterTransmission = async () => {
  await store.ajouterTransmission({
    message: nouvelleTransmission.value.message,
    jour: nouvelleTransmission.value.jour,
    heure_debut: nouvelleTransmission.value.heure_debut,
    heure_fin: nouvelleTransmission.value.heure_fin,
    okeemien_id: okeemien.value.id,
    enfant_id: selectedEnfant.value,
  })
  const now = new Date()

  // date au format yyyy-mm-dd
  const dateStr = now.toISOString().split('T')[0]

  // heure actuelle au format HH:mm
  const heureDebut = now.toTimeString().slice(0, 5)

  const plusUneHeure = new Date(now.getTime() + 60 * 60 * 1000)
  const heureFin = plusUneHeure.toTimeString().slice(0, 5)

  nouvelleTransmission.value.jour = dateStr
  nouvelleTransmission.value.heure_debut = heureDebut
  nouvelleTransmission.value.heure_fin = heureFin
  nouvelleTransmission.value = {
    message: '',
    jour: dateStr,
    heure_debut: heureDebut,
    heure_fin: heureFin,
  }
}

const ouvrirPopupModification = (transmission) => {
  modifTransmission.value = { ...transmission }
  popupModification.value = true
}

const modifierTransmission = () => {
  store.modifierTransmission(modifTransmission.value)
  popupModification.value = false
}
</script>
