<template>
  <v-app>
    <v-app-bar app color="primary" dark>
      <!-- Bouton retour (affiché uniquement si historique > 1) -->
      <template v-if="canGoBack">
        <v-btn icon @click="goBack" class="ml-2">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
      </template>
      <template v-else>
        <!-- Placeholder invisible pour garder alignement si besoin -->
        <div style="width: 40px" class="ml-2 mr-2"></div>
      </template>

      <v-toolbar-title class="d-flex align-center">
        <router-link
          to="/"
          style="text-decoration: none; color: inherit"
          class="d-flex align-center"
        >
          <v-img :src="logo" contain height="64" width="64" class="mr-2"></v-img>
          Okeem !
        </router-link>
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn size="small" v-if="etablissement" :to="'/' + etablissement">{{
        etablissement.nom
      }}</v-btn>
      <v-btn
        size="small"
        v-if="etablissement"
        :to="'/' + etablissement + '/tableau-de-bord'"
        icon
        :title="'Tableau de Bord'"
      >
        <v-icon>mdi-view-dashboard</v-icon>
      </v-btn>
      <v-btn size="small" icon :title="'Se déconnecter'" @click="deconnexion">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import logo from '@/assets/logo_okeem.png'
import { storeToRefs } from 'pinia'
import { useEtablissementStore } from '@/stores/useEtablissementStore'
import { useRouter, useRoute } from 'vue-router'
import { computed } from 'vue'

const router = useRouter()
const route = useRoute()

const canGoBack = computed(() => {
  return window.history.length > 1 && route.path !== '/'
})

function goBack() {
  router.back()
}

function deconnexion() {
  localStorage.removeItem('acces_autorise')
  router.push('/auth')
}

const store = useEtablissementStore()
const { etablissement, enfant } = storeToRefs(store)
</script>
