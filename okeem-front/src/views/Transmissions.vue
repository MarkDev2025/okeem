<template>
  <v-container>
    <v-card elevation="2">
      <v-card-title>Transmissions</v-card-title>
      <v-card-text>
        <v-row v-if="!loading">
          <v-col cols="12" v-for="transmission in transmissions" :key="transmission.id">
            <v-card variant="outlined">
              <v-card-title class="text-subtitle-1">{{ transmission.date }}</v-card-title>
              <v-card-text>{{ transmission.commentaires }}</v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" v-if="transmissions.length === 0">
            <v-alert type="info" text="Aucune transmission trouvée"></v-alert>
          </v-col>
        </v-row>
        <v-progress-circular v-if="loading" indeterminate color="primary"></v-progress-circular>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

interface Transmission {
  id: number;
  date: string;
  commentaires: string;
}

export default defineComponent({
  name: 'Transmissions',
  data() {
    return {
      transmissions: [] as Transmission[],
      loading: true
    };
  },
  mounted() {
    // Simuler un chargement pour test (à remplacer par l'API réelle)
    setTimeout(() => {
      this.transmissions = [
        { id: 1, date: '18/03/2025', commentaires: 'Lucas a bien mangé aujourd\'hui.' },
        { id: 2, date: '17/03/2025', commentaires: 'Emma a participé à l\'activité peinture.' },
        { id: 3, date: '16/03/2025', commentaires: 'Noah a fait la sieste pendant 2 heures.' }
      ];
      this.loading = false;
    }, 500);
    
    // Code réel:
    // fetch('/api/transmissions')
    //   .then(res => res.json())
    //   .then(data => {
    //     this.transmissions = data;
    //     this.loading = false;
    //   })
    //   .catch(err => {
    //     console.error(err);
    //     this.loading = false;
    //   });
  }
});
</script>