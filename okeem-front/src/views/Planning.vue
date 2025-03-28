<template>
  <v-container>
    <v-card elevation="2">
      <v-card-title>Planning</v-card-title>
      <v-card-text>
        <v-data-table
          v-if="!loading"
          :headers="headers"
          :items="planning"
          :items-per-page="5"
          class="elevation-1"
        ></v-data-table>
        <v-progress-circular v-if="loading" indeterminate color="primary"></v-progress-circular>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

interface PlanningItem {
  enfant: string;
  date: string;
}

export default defineComponent({
  name: 'Planning',
  data() {
    return {
      planning: [] as PlanningItem[],
      loading: true,
      headers: [
        { title: 'Enfant', key: 'enfant' },
        { title: 'Date', key: 'date' }
      ]
    };
  },
  mounted() {
    // Simuler un chargement pour test (à remplacer par l'API réelle)
    setTimeout(() => {
      this.planning = [
        { enfant: 'Lucas', date: '2025-03-18' },
        { enfant: 'Emma', date: '2025-03-19' },
        { enfant: 'Noah', date: '2025-03-20' }
      ];
      this.loading = false;
    }, 500);
    
    // Code réel:
    // fetch('/api/plannings')
    //   .then(res => res.json())
    //   .then(data => {
    //     this.planning = data;
    //     this.loading = false;
    //   })
    //   .catch(err => {
    //     console.error(err);
    //     this.loading = false;
    //   });
  }
});
</script>