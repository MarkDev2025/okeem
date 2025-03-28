import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import DashboardView from '@/views/DashboardView.vue';
import TransmissionView from '@/views/TransmissionView.vue';
import ParentView from '@/views/ParentView.vue';
import OkeemienView from '@/views/OkeemienView.vue';
import EnfantView from '@/views/EnfantView.vue';
import SelectEtablissementView from '@/views/SelectEtablissementView.vue';
import EtablissementView from '@/views/EtablissementView.vue';
import PasswordGuard from '@/views/PasswordGuard.vue'


const routes = [
  {
    path: '/auth',
    name: 'Auth',
    component: PasswordGuard,
  },
  { path: '/', component: SelectEtablissementView, name: 'select-etablissement' },
  { path: '/:etablissement', component: EtablissementView, name: 'etablissement' },
  { path: '/:etablissement/tableau-de-bord', component: DashboardView, name: 'dashboard' },
  { path: '/:etablissement/:okeemien/transmission/:enfant', name: 'transmission', component: TransmissionView },
  { path: '/:etablissement/parent/:slug_parent', name: 'parent', component: ParentView },
  { path: '/:etablissement/okeemien/:slug_okeemien', name: 'okeemien', component: OkeemienView },
  { path: '/:etablissement/enfant/:slug_enfant', name: 'enfant', component: EnfantView }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const accesAutorise = localStorage.getItem('acces_autorise')

  // on laisse passer si route publique ou si accès déjà validé
  if (to.path === '/auth' || accesAutorise === 'true') {
    next()
  } else {
    next('/auth')
  }
})


export default router;