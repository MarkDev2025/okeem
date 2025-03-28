<template>
  <v-container>
    <v-card class="mb-2">
      <v-card-title class="pb-0">Tableau de Bord</v-card-title>
      <v-card-subtitle class="text-caption mb-2">(vue gestionnaire)</v-card-subtitle>
    </v-card>

    <v-row>
      <!-- ENFANTS -->
      <v-col>
        <v-card>
          <v-list density="compact">
            <v-list-group value="enfants">
              <template #activator="{ props }">
                <v-list-item v-bind="props">
                  <v-list-item-title class="font-weight-bold">Enfants</v-list-item-title>
                </v-list-item>
              </template>

              <v-list-item
                id="custom-padding"
                :prepend-avatar="getChatonImagePath(enfant.id)"
                :title="`${enfant.prenom} ${enfant.nom}`"
                v-for="enfant in enfants"
                :key="enfant.id"
                :to="`/${etablissement.slug}/enfant/${enfant.slug}`"
              >
              </v-list-item>
            </v-list-group>
          </v-list>
        </v-card>
      </v-col>

      <!-- PARENTS -->
      <v-col cols="12" md="6">
        <v-card>
          <v-list density="compact">
            <v-list-group value="parents">
              <template #activator="{ props }">
                <v-list-item v-bind="props">
                  <v-list-item-title class="font-weight-bold">Parents</v-list-item-title>
                </v-list-item>
              </template>
              <v-list-item
                id="custom-padding"
                v-for="tuteur in tuteurs"
                :key="tuteur.id"
                :to="`/${etablissement.slug}/parent/${tuteur.slug}`"
                :prepend-avatar="`https://i.pravatar.cc/150?img=${tuteur.id}`"
              >
                <v-list-item-title>{{ tuteur.prenom }} {{ tuteur.nom }}</v-list-item-title>
              </v-list-item>
            </v-list-group>
          </v-list>
        </v-card>
      </v-col>

      <!-- ÉDUCATEURS -->
      <v-col cols="12" md="6">
        <v-card>
          <v-list density="compact">
            <v-list-group value="educateurs">
              <template #activator="{ props }">
                <v-list-item v-bind="props">
                  <v-list-item-title class="font-weight-bold">Okeemiens</v-list-item-title>
                </v-list-item>
              </template>

              <v-list-item
                id="custom-padding"
                :prepend-avatar="getAvatarUrl('okeemien.png')"
                :title="`${okeemien.prenom} ${okeemien.nom}`"
                v-for="okeemien in okeemiens"
                :key="okeemien.id"
                :to="`/${etablissement.slug}/okeemien/${okeemien.slug}`"
              >
              </v-list-item>
            </v-list-group>
          </v-list>
        </v-card>
      </v-col>

      <!-- TRANSMISSIONS -->
      <v-col cols="12" md="6">
        <v-card>
          <v-list density="compact">
            <v-list-group value="transmissions">
              <template #activator="{ props }">
                <v-list-item v-bind="props">
                  <v-list-item-title class="font-weight-bold"
                    >Dernières Transmissions</v-list-item-title
                  >
                </v-list-item>
              </template>

              <v-list-item
                id="custom-padding"
                :prepend-avatar="getChatonImagePath(transmission.enfant.id)"
                :title="`${transmission.message} à ${transmission.heure_debut}`"
                :subtitle="`${transmission.enfant.prenom} ${transmission.enfant.nom}`"
                v-for="transmission in transmissions"
                :key="transmission.id"
                :to="`/${etablissement.slug}/enfant/${transmission.enfant.slug}`"
              >
              </v-list-item>
            </v-list-group>
          </v-list>
        </v-card>
      </v-col>
    </v-row>

    <!-- Statistiques -->
    <v-row>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-subtitle class="pt-2"
            >Nombre d'absences <span class="text-caption">(statique)</span></v-card-subtitle
          >
          <v-card-item>2</v-card-item>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-subtitle class="pt-2"
            >Nombre de retards <span class="text-caption">(statique)</span></v-card-subtitle
          >
          <v-card-item>5</v-card-item>
        </v-card>
      </v-col>
    </v-row>
    <!-- État des factures (camembert fictif) -->
    <v-row>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-subtitle class="pt-2">État des factures <span class="text-caption">(statique)</span></v-card-subtitle>
          <v-card-item>
            <canvas id="factures-chart" height="180"></canvas>
          </v-card-item>
        </v-card>
      </v-col>

      <!-- ToDo administrative -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-subtitle class="pt-2">Tâches administratives <span class="text-caption">(statique)</span></v-card-subtitle>
          <v-card-item>
            <v-list density="compact">
              <v-list-item v-for="(task, index) in tasks" :key="index">
                <v-checkbox v-model="task.done" :label="task.label" hide-details class="todo-checkbox">
                  <template #label>
                    <span :style="{ textDecoration: task.done ? 'line-through' : 'none' }" class="text-caption">
                      {{ task.label }}
                    </span>
                  </template>
                </v-checkbox>
              </v-list-item>
            </v-list>
          </v-card-item>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<style>
#custom-padding {
  padding-inline-start: 16px !important;
}
.todo-checkbox {
  margin-top: -4px;
  margin-bottom: -4px;
}
</style>
<script setup>
import { useRoute } from 'vue-router'
import { useEtablissementStore } from '@/stores/useEtablissementStore'
import { storeToRefs } from 'pinia'
import { onMounted, reactive } from 'vue'
import { getChatonImagePath } from '@/helpers/avatar'
import Chart from 'chart.js/auto'
import { getAvatarUrl } from '@/config'


const tasks = reactive([
  { label: 'Envoyer les factures de mars', done: false },
  { label: 'Vérifier les présences du lundi', done: true },
  { label: 'Télécharger le rapport mensuel', done: false },
  { label: 'Répondre aux messages parents', done: false },
])
const route = useRoute()
const store = useEtablissementStore()
const { etablissement, enfants, tuteurs, okeemiens, transmissions } = storeToRefs(store)

onMounted(() => {
  if (route.params.etablissement) {
    store.loadDataBySlug(route.params.etablissement)
  }
  const ctx = document.getElementById('factures-chart')
  if (ctx) {
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Payées', 'Envoyées', 'En retard'],
        datasets: [
          {
            data: [10, 5, 2],
            backgroundColor: ['#4caf50', '#2196f3', '#f44336'],
          },
        ],
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom',
          },
        },
        responsive: true,
        maintainAspectRatio: false,
      },
    })
  }
})
</script>
